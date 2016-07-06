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
use Minor\Route\Url;

class App
{
    private static $_instance = null;

    private $minorRequest = null;

    private $minorResponse = null;

    private $serviceContainer = null;

    private $router = null;
    
    private function __construct(Array $config, Array $providers, Array $routes, Array $events)
    {
        !empty($config['app']) && $this->initAppByConfig($config['app']);

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
        $this->minorRequest  = $minorRequest;
        $this->minorResponse = MinorResponse::getInstance();

        list($controllerName, $actionName, $params) = $this->router->dispatcher($this->minorRequest->getUrl());

        if (!($controllerName && $actionName && is_array($params))) {
            if (!Config::get(['app' => 'DEBUG']) && ($handler = Config::get(['app' => '404_HANDLER'])) && ($handler instanceof \Closure)) {
                $handler($minorRequest->getRequestUrl());
            } else {
                throw new AppException('404 Not Found');
            }
        } else {
            $res = $this->invoke($controllerName, $actionName, $params);
            $res === $this->minorResponse ? $this->minorResponse = $res : $this->minorResponse->appendContent($res);
        }

        return $this->minorResponse;
    }

    public function invoke($controllerName, $actionName, Array $params = [])
    {
        try {

            list($controller, $action) = ControllerBuilder::buildController($controllerName, $actionName, $this);

            return $action->invokeArgs($controller, $params);
        } catch (ControllerException $ce) {
            throw $ce;
        } catch (ReflectionException $re) {
            throw new ControllerException('自定义控制器[' . $controllerName . ']:方法[' . $actionName . ']执行失败,请检查路由配置');
        }
    }

    private function initAppByConfig(Array $appConfig)
    {
        !empty($appConfig['CHARSET'])  && header('Content-type:text/html;charset=' . $appConfig['CHARSET']);

        !empty($appConfig['TIMEZONE']) && date_default_timezone_set($appConfig['TIMEZONE']);

        if (empty($appConfig['DEBUG'])) {

            ini_set('html_errors',false);
            ini_set('display_errors',false);

            !empty($appConfig['EXCEPTION_HANDLER']) && ($appConfig['EXCEPTION_HANDLER'] instanceof \Closure) && set_exception_handler($appConfig['EXCEPTION_HANDLER']);
            !empty($appConfig['ERROR_HANDLER'])     && ($appConfig['ERROR_HANDLER'] instanceof \Closure)     && set_error_handler($appConfig['ERROR_HANDLER']);
        }
    }

    public function getServiceContainer()
    {
        return $this->serviceContainer;
    }

    public function getRouter()
    {
        return $this->router;
    }

    public function getMinorRequest()
    {
        return $this->minorRequest;
    }

    public function getMinorResponse()
    {
        return $this->minorResponse;
    }
}