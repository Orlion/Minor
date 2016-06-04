<?php

namespace Minor\Route;

class UrlGenerator
{
    public static function generateUrl($urlOriginal, Array $routes)
    {
        $urlOriginalArray = parse_url(trim($urlOriginal));
        $mca = explode('/', !empty($urlOriginalArray['path']) ? $urlOriginalArray['path'] : '');

        if (4 === count($mca)) {
            $controller = 'App\Modules\\' . $mca[1] . '\Controller\\' . $mca[2] . 'Controller';
            if ($route = self::getRouteByControllerAction($controller, $mca[3], $routes)) {
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

                return  preg_match('#{(\w+)}#', $routeRule) ? $urlOriginal : $routeRule . (!empty($urlOriginalArray['fragment']) ? '#' . $urlOriginalArray['fragment'] : '');
            }
        }

        return $urlOriginal;
    }

    private static function getRouteByControllerAction($controller, $action, Array $routes)
    {
        foreach ($routes as $routeRule => $routeParams) {
            if (empty($routeParams['controller']) || empty($routeParams['action']))
                throw new ConfigException('路由:[' . $routeRule . ']配置缺少参数');
            if (strtolower($routeParams['controller']) === strtolower($controller) && $routeParams['action'] === $action) {
                return [$routeRule, $routes[$routeRule]];
            }
        }

        return false;
    }
}