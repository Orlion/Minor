<?php

namespace Minor\Framework;

use Minor\Config\Config;
use Minor\Event\EventManager;
use Minor\HttpKernel\MinorRequest;
use Minor\Controller\ControllerException;
use Minor\Controller\ControllerBuilder;
use Minor\HttpKernel\MinorResponse;
use Minor\Ioc\ServiceContainer;
use Minor\Route\Router;
use Minor\Route\RouteException;

class App
{
    private static $_instance = null;

    private $minorRequest = null;

    private $serviceContainer = null;

    private $router = null;
    
    private function __construct(Array $config, Array $providers, Array $routes, Array $events)
    {
        Config::init($config);

        $this->serviceContainer =ServiceContainer::getInstance($providers);

        $this->router = Router::getInstance($routes);

        EventManager::init($events);
    }
    
    private function __clone(){}
    
    public static function getInstance(Array $config, Array $providers, Array $routes, Array $events)
    {
        if (is_null(self::$_instance) || !self::$_instance instanceof self) {
            self::$_instance = new self($config, $providers, $routes, $events);
        }
        
        return self::$_instance;
    }
    
    public function handle(MinorRequest $minorRequest)
    {
        $this->minorRequest = $minorRequest;

        list($controllerName, $actionName, $params) = $this->router->dispatcher($minorRequest->getUrl());

        if (!($controllerName && $actionName && is_array($params)))
            throw new RouteException('404');

        return $this->invoke($controllerName, $actionName, $params);
    }

    public function invoke($controllerName, $actionName, Array $params = [])
    {
        list($controller, $action) = ControllerBuilder::buildController($controllerName, $actionName);

        // 注入
        $controller->app = $this;
        $controller->minorRequest  = $this->minorRequest;
        $controller->minorResponse = MinorResponse::getInstance();

        try {
            $res = $action->invokeArgs($controller, $params);
            $res !==  $controller->minorResponse && $controller->minorResponse->setContent($res);
        } catch (ReflectionException $re) {
            throw new ControllerException('自定义控制器[' . $controllerName . ']:方法[' . $actionName . ']执行失败，请检查配置文件');
        }

        return $controller->minorResponse;
    }

    public function getServiceContainer()
    {
        return $this->serviceContainer;
    }

    public function getRouter()
    {
        return $this->router;
    }
}