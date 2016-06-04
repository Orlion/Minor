<?php
/**
 * Minor - A PHP Framework [It just did what a framework should do.]
 *
 * @package  Minor
 * @author   Orlion <orlionml@gmail.com>
 */
namespace Minor;

use Minor\Config\Config;
use Minor\Framework\Context;
use Minor\Ioc\ServiceContainer;
use Minor\HttpKernel\MinorRequestBuilder;
use Minor\HttpKernel\MinorResponseBuilder;
use Minor\Framework\App;

class Minor
{
    public static function run()
    {
        self::bootstrap();

        $config = Config::getInstance();
        Context::setConfig($config);

        self::settings();

        $serviceContainer = ServiceContainer::getInstance();
        Context::setServiceContainer($serviceContainer);

        $minorRequest = MinorRequestBuilder::buildMinorRequest();
        Context::setMinorRequest($minorRequest);

        $minorResponse = MinorResponseBuilder::buildMinorResponse();
        Context::setMinorResponse($minorResponse);

        $app = App::getInstance();
        Context::setApp($app);

        $minorResponse = $app->handle($minorRequest);

        echo (string)$minorResponse;
    }

    private static function bootstrap()
    {
        require VENDOR_DIR . 'Config/Config.php';
        require VENDOR_DIR . 'Config/ConfigException.php';

        require VENDOR_DIR . 'Controller/Controller.php';
        require VENDOR_DIR . 'Controller/ControllerBuilder.php';
        require VENDOR_DIR . 'Controller/ControllerException.php';

        require VENDOR_DIR . 'Framework/App.php';
        require VENDOR_DIR . 'Framework/Context.php';

        require VENDOR_DIR . 'HttpKernel/MinorCookie.php';
        require VENDOR_DIR . 'HttpKernel/MinorRequest.php';
        require VENDOR_DIR . 'HttpKernel/MinorRequestBuilder.php';
        require VENDOR_DIR . 'HttpKernel/MinorResponse.php';
        require VENDOR_DIR . 'HttpKernel/MinorResponseBuilder.php';
        require VENDOR_DIR . 'HttpKernel/MinorSession.php';

        require VENDOR_DIR . 'Route/Router.php';
        require VENDOR_DIR . 'Route/RouteException.php';
        require VENDOR_DIR . 'Route/UrlDispatcher.php';
        require VENDOR_DIR . 'Route/UrlGenerator.php';
        require VENDOR_DIR . 'Route/UrlTools.php';

        require VENDOR_DIR . 'autoload.php';
    }

    private static function settings()
    {
        $appConfig = Context::getConfig()->getApp();
        if (empty($appConfig['DEBUG']))
            error_reporting(0);

        if (!empty($appConfig['DEFAULT_ERROR']) && $appConfig['DEFAULT_ERROR'] instanceof \Closure)
            set_error_handler($appConfig['DEFAULT_ERROR']);

        if (!empty($appConfig['DEFAULT_EXCEPTION']) && $appConfig['DEFAULT_EXCEPTION'] instanceof \Closure)
            set_exception_handler($appConfig['DEFAULT_EXCEPTION']);
    }
}