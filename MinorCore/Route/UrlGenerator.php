<?php

namespace MinorCore\Route;

use MinorCore\Config\ConfigTools;

class UrlGenerator{

	private static $routes = [];

	/**
	 * 生成url,将module/controller/action?key=value型url转为符合路由规则的url
	 *
	 * @param  string $urlOriginal fg: module/controller/action?key1=val2&key2=val3#key3=val3
	 * @return string $url
	 */
	public static function generateUrl($urlOriginal){

		$urlOriginalArray = parse_url(trim($urlOriginal));

		$routes = self::getRoutes();

		$MCA = explode('/', !empty($urlOriginalArray['path']) ? $urlOriginalArray['path'] : '');

		if (3 === count($MCA)) {

			$routeRule = self::getRouteByMCA($MCA[0] , $MCA[1] , $MCA[2]);

			if ($routeRule && !empty($urlOriginalArray['query'])) {

				$replace = function ($paramVal , $paramKey) use (&$routeRule){

					if (strstr($routeRule , '{' . $paramKey . '}')) {

						$routeRule = str_replace('{' . $paramKey . '}' , $paramVal , $routeRule);
					} else {

						$routeRule .= (strstr($routeRule , '?') ? '&' : '?') . $paramKey . '=' . $paramVal;
					}
				};

				parse_str($urlOriginalArray['query'] , $queryArr);
				array_walk($queryArr , $replace);
			}

			return  preg_match('/{(\w+)}/', $routeRule) ? $urlOriginal : $routeRule . (!empty($urlOriginalArray['fragment']) ? '#' . $urlOriginalArray['fragment'] : '');
		}

		return $urlOriginal;
	}

	/**
	 * 获取Module/Controller/Action对应的路由规则
	 */
	private static function getRouteByMCA($module , $controller , $action){

		$routes = self::getRoutes();

		foreach ($routes as $routeRule => $routeParams) {

			if (empty($routeParams['controller']) || empty($routeParams['action'])) 
				throw new RouteException('路由:' . $urlPatternOriginal . '缺少参数');
			
			if ($routeParams['controller'] === $module . '\\' . $controller && $routeParams['action'] === $action) {

				return $routeRule;
			}
		}

		return FALSE;
	}

	/**
	 * 获取路由配置
	 */
	private static function getRoutes(){

		return count(self::$routes) ? self::$routes : ConfigTools::getRoutes();
	}
}
?>