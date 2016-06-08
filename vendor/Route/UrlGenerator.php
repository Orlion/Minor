<?php

namespace Minor\Route;

class UrlGenerator
{

    private static $_instance = null;

    private $routes = [];

    private function __construct(Array $routes)
    {
        $this->routes = $routes;
    }

    private function __clone(){}

    public static function getInstance(Array $routes)
    {
        if (is_null(self::$_instance) || !self::$_instance instanceof self) {
            self::$_instance = new self($routes);
        }

        return self::$_instance;
    }

    public function generateUrl($path)
    {
        $urlOriginalArray = parse_url(trim($path));
        $mca = explode('/', !empty($urlOriginalArray['path']) ? $urlOriginalArray['path'] : '');

        if (4 === count($mca)) {
            $controller = 'App\Modules\\' . $mca[1] . '\Controller\\' . $mca[2] . 'Controller';
            if ($route = $this->getRouteByControllerAction($controller, $mca[3], $this->routes)) {
                list($routeRule, $routeConfig) = $route;
                $replace = function($paramVal, $paramKey) use (&$routeRule, $routeConfig){
                    if (strstr($routeRule , '{' . $paramKey . '}')) {
                        if (empty($routeConfig['required']) || preg_match('(' . $routeConfig['required'][$paramKey] . ')', $paramVal)) {
                            $routeRule = str_replace('{' . $paramKey . '}' , $paramVal , $routeRule);
                        }
                    }
                };
                parse_str($urlOriginalArray['query'] , $queryArr);
                array_walk($queryArr , $replace);

                return  preg_match('#{(\w+)}#', $routeRule) ? $path : $routeRule . (!empty($urlOriginalArray['fragment']) ? '#' . $urlOriginalArray['fragment'] : '');
            }
        }

        return $path;
    }

    private function getRouteByControllerAction($controller, $action)
    {
        foreach ($this->routes as $routeRule => $routeParams) {
            if (empty($routeParams['controller']) || empty($routeParams['action']))
                throw new ConfigException('路由:[' . $routeRule . ']配置缺少参数');
            if (strtolower($routeParams['controller']) === strtolower($controller) && $routeParams['action'] === $action) {
                return [$routeRule, $this->routes[$routeRule]];
            }
        }

        return false;
    }
}