<?php

namespace Minor\Framework;

use Minor\HttpKernel\MinorRequest;
use Minor\Config\Config;
use Minor\HttpKernel\MinorResponse;
use Minor\Ioc\ServiceContainer;

class Context
{
    private static $minorRequest = null;

    private static $minorResponse = null;
    
    private static $app = null;
    
    private static $serviceContainer = null;

    private static $config = null;
    
    public static function setMinorRequest(MinorRequest $minorRequest)
    {
        self::$minorRequest = $minorRequest;
    }
    
    public static function getMinorRequest()
    {
        return self::$minorRequest;
    }
    
    public static function setApp(App $app)
    {
        self::$app = $app;
    }
    
    public static function getApp()
    {
        return self::$app;
    }

    public static function setServiceContainer(ServiceContainer $serviceContainer)
    {
        self::$serviceContainer = $serviceContainer;
    }
    
    public static function getServiceContainer()
    {
        return self::$serviceContainer;
    }
    public static function setConfig(Config $config)
    {
        self::$config = $config;
    }

    public static function getConfig()
    {
        return self::$config;
    }

    public static function setMinorResponse(MinorResponse $minorResponse)
    {
        self::$minorResponse = $minorResponse;
    }

    public static function getMinorResponse()
    {
        return self::$minorResponse;
    }
}
