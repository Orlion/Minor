<?php

namespace Minor\Framework;

use Minor\Config\Config;
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

    private $minorResponse = null;

    private $serviceContainer = null;

    private $router = null;
    
    private function __construct(Array $config, ServiceContainer $serviceContainer, Router $router, Array $events)
    {
        Config::init($config);
        $this->serviceContainer = $serviceContainer;
        $this->router = $router;

        $this->minorResponse = MinorResponse::getInstance();
    }
    
    private function __clone(){}
    
    public static function getInstance(ServiceContainer $serviceContainer)
    {
        if (is_null(self::$_instance) || !self::$_instance instanceof self) {
            self::$_instance = new self($serviceContainer);
        }
        
        return self::$_instance;
    }
    
    public function handle(MinorRequest $minorRequest)
    {
        list($controllerName, $actionName, $params) = $this->router->dispatcher($minorRequest->getUrl());

        if (!($controllerName && $actionName && is_array($params)))
            throw new RouteException('404');

        return $this->invoke($controllerName, $actionName, $params);
    }

    public function invoke($controllerName, $actionName, Array $params)
    {
        list($controller, $action) = ControllerBuilder::buildController($controllerName, $actionName);
        try {
            $res = $action->invokeArgs($controller, $params);
            ($res instanceof MinorResponse) ? $this->minorResponse = $res : $this->minorResponse->appendContent($res);
        } catch (ReflectionException $re) {
            throw new ControllerException('自定义控制器[' . $controllerName . ']:方法[' . $actionName . ']执行失败，请检查配置文件');
        }

        return $this->minorResponse;
    }

    public function get($serviceName)
    {
        return $this->serviceContainer->get($serviceName);
    }

    public function bind($serviceName, $service)
    {
        $this->serviceContainer->bind($serviceName, $service);
    }

    public function singleton($serviceName, $service)
    {
        $this->serviceContainer->singleton($serviceName, $service);
    }
}