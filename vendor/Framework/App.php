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
use Minor\Route\Url;
use Minor\View\View;

class App
{
    private static $_instance = null;

    private $minorRequest = null;

    private $serviceContainer = null;

    private $router = null;
    
    private function __construct(Array $config, Array $providers, Array $routes, Array $events)
    {
        !empty($config['app']) && $this->init($config['app']);

        Config::init($config);

        $this->serviceContainer =ServiceContainer::getInstance($providers);

        $this->router = Router::getInstance($routes);

        Url::setRouter($this->router);

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
        $minorResponse = MinorResponse::getInstance();

        $this->minorRequest = $minorRequest;

        list($controllerName, $actionName, $params) = $this->router->dispatcher($minorRequest->getUrl());

        if (!($controllerName && $actionName && is_array($params))) {
            if (!Config::get(['app' => 'DEBUG']) && ($handler = Config::get(['app' => '404_HANDLER'])) && ($handler instanceof \Closure)) {
                $handler($minorRequest->getRequestUrl());
            } else {
                throw new RouteException('404 Not Found');
            }
        } else {
            $minorResponse = $this->invoke($controllerName, $actionName, $params);
        }

        return $minorResponse;
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

    private function init(Array $appConfig)
    {
        !empty($appConfig['CHARSET'])  && header('Content-type:text/html;charset=' . $appConfig['CHARSET']);

        !empty($appConfig['TIMEZONE']) && date_default_timezone_set($appConfig['TIMEZONE']);

        if (empty($appConfig['DEBUG'])) {

            ini_set('html_errors',false);
            ini_set('display_errors',false);

            !empty($appConfig['EXCEPTION_HANDLER']) && ($appConfig['EXCEPTION_HANDLER'] instanceof \Closure) && set_exception_handler($appConfig['EXCEPTION_HANDLER']);

            !empty($appConfig['ERROR_HANDLER']) && ($appConfig['ERROR_HANDLER'] instanceof \Closure) && set_error_handler($appConfig['ERROR_HANDLER']);
        }
    }
}