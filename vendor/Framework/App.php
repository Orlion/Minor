<?php

namespace Minor\Framework;

use Minor\HttpKernel\MinorRequest;
use Minor\Controller\ControllerException;
use Minor\Controller\ControllerBuilder;
use Minor\Route\Router;
use Minor\Route\RouteException;

class App
{
    private static $_instance = null;
    
    private function __construct(){}
    
    private function __clone(){}
    
    public static function getInstance()
    {
        if (is_null(self::$_instance) || !self::$_instance instanceof self) {
            self::$_instance = new self();
        }
        
        return self::$_instance;
    }
    
    public function handle(MinorRequest $minorRequest)
    {
        $url = $minorRequest->getUrl();
        list($controllerName, $actionName, $params) = Router::getControllerActionParams($url);

        if (!($controllerName && $actionName && is_array($params)))
            throw new RouteException('404');

        return $this->invoke($controllerName, $actionName, $params);
    }

    public function invoke($controllerName, $actionName, Array $params)
    {
        list($controller, $action) = ControllerBuilder::buildController($controllerName, $actionName);
        try {
            return $action->invokeArgs($controller, $params);
        } catch (ReflectionException $re) {
            throw new ControllerException('自定义控制器[' . $controllerName . ']:方法[' . $actionName . ']执行失败，请检查配置文件');
        }

        return null;
    }
}