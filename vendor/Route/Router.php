<?php

namespace Minor\Route;

class Router
{
    private static $_instance = null;

    private $routesConfig = [];

    private function __construct(Array $routesConfig)
    {
        $this->routesConfig = $routesConfig;
    }

    private function __clone(){}

    public static function getInstance(Array $routesConfig)
    {
        if (is_null(self::$_instance) || !self::$_instance instanceof self) {
            self::$_instance = new self($routesConfig);
        }

        return self::$_instance;
    }
    public function dispatcher($url)
    {
        $urlDispatcher = UrlDispatcher::getInstance($this->routesConfig);

        return $urlDispatcher->getControllerActionParams($url);
    }

    public function to($path)
    {
        $urlGenerator = UrlGenerator::getInstance($this->routesConfig);
        return $urlGenerator->generateUrl($path);
    }
}
