<?php

namespace Minor\Route;

use Minor\Config\ConfigException;

class UrlDispatcher
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

    public function getControllerActionParams($url)
    {
        $controllerActionParams = ['', '', []];

        if (empty($this->routes[$url])) {
            foreach ($this->routes as $routePatternOriginal => $routeParams) {
                if (empty($routeParams['required'])) {
                    $required = [];
                } else if (!is_array($routeParams['required'])) {
                    throw new ConfigException('路由:[' . $routePatternOriginal . ']配置项[required]必须为数组');
                } else {
                    $required = $routeParams['required'];
                }

                $routePattern = $this->generateRoutePattern($routePatternOriginal, $required);
                if (preg_match($routePattern, $url, $matches)) {
                    $controllerActionParams = $this->getRouteConfig($routeParams, $routePatternOriginal, $matches);
                    break;
                }
            }
        } else {
            $controllerActionParams = $this->getRouteConfig($this->routes[$url], $url, []);
        }

        if (empty($controllerActionParams[0])) {
            $controllerActionParams = $this->getDefaultControllerAction($url);
        }

        return $controllerActionParams;
    }

    private function generateRoutePattern($routePatternOriginal,Array $routeRequired)
    {
        $routePatternOriginal = str_replace('\{' , '{', trim($routePatternOriginal));
        $routePatternOriginal = str_replace('\}' , '}', $routePatternOriginal);

        if (preg_match_all('/{(\w+)}/', $routePatternOriginal, $matches)) {
            $paramsNum = count($matches[1]);
            for ($i = 0; $i < $paramsNum; $i++) {
                $paramPattern  = !empty($routeRequired[$matches[1][$i]]) ? $routeRequired[$matches[1][$i]] : '.+';
                $replacePattern = '(' . $paramPattern . ')';
                $routePatternOriginal = str_replace($matches[0][$i] , $replacePattern , $routePatternOriginal);
            }
        }

        return '#^' . $routePatternOriginal . '$#';
    }

    private function getRouteConfig(Array $routeParams, $routePatternOriginal, Array $matches)
    {
        if (empty($routeParams['controller']))
            throw new ConfigException('路由:[' . $routePatternOriginal . ']缺少Controller参数');

        if (empty($routeParams['action']))
            throw new ConfigException('路由:[' . $routePatternOriginal . ']缺少action参数');

        array_shift($matches);

        return [$routeParams['controller'], $routeParams['action'], $matches];
    }

    private function getDefaultControllerAction($url)
    {
        $controllerActionParams = ['', '', []];

        $routePattern = '#^' . '/(\w+)/(\w+)/(\w+)#';
        if ($controllerActionArr = $this->match($routePattern, $url)) {
            $controllerActionParams = [$controllerActionArr[0], $controllerActionArr[1], []];
        }

        return $controllerActionParams;
    }

    private function match($routePattern , $url)
    {
        if (preg_match($routePattern , $url , $matches)) {
            return ['App\Modules\\' . ucfirst($matches[1]) . '\Controller\\' . ucfirst($matches[2]) . 'Controller', $matches[3]];
        }

        return FALSE;
    }
}