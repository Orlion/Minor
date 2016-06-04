<?php

namespace Minor\Route;

use Minor\Framework\Context;

class Router
{
    private static $urlDispatcher = null;

    private static $urlGenerator = null;

    public static function getControllerActionParams($url)
    {
        $baseUrl = UrlTools::getBaseUrl($url);
        $url = parse_url(rawurldecode($url) , PHP_URL_PATH);

        return UrlDispatcher::getControllerActionParams(str_replace($baseUrl , '' , $url), Context::getConfig()->getRoutes());
    }

    public static function genUrl($urlOriginal)
    {
        return UrlGenerator::generateUrl($urlOriginal, Context::getConfig()->getRoutes());
    }

    public static function setUrlDispatcher(UrlDispatcher $urlDispatcher)
    {
        self::$urlDispatcher = $urlDispatcher;
    }

    public static function setUrlGenerator(UrlGenerator $urlGenerator)
    {
        self::$urlGenerator = $urlGenerator;
    }
}