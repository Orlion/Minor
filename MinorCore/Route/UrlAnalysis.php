<?php

namespace MinorCore\Route;

use MinorCore\Config\ConfigTools;

class UrlAnalysis{

	private static $routes;

	/**
	 * 解析url对应的module、controller、action、param、filter
	 *
	 * @param  string $url
	 * @return array  [$moduleName , $controllerName , $actionName , $params , $filter]
	 */
	public static function getMCAPF($url){

		$moduleName = $controllerName = $actionName = ''; $params = $filter = [];

		$routes = self::getRoutes();

		foreach ($routes as $urlPatternOriginal => $urlParams) {
			
			list($urlPattern , $paramsKey) = self::generateUrlPattern($urlPatternOriginal , !empty($urlParams['required']) ? $urlParams['required'] : []);
			
			if (preg_match($urlPattern , $url , $matches)) {

				list($moduleName , $controllerName , $actionName , $param , $filter) = self::get();
				break;
			}
		}

		if (empty($moduleName) || empty($controllerName) || empty($actionName)) {

			list($moduleName , $controllerName , $actionName) = self::getMCADefault($url);

			if (empty($moduleName) || empty($controllerName) || empty($actionName)) 
				throw new RouteException("404");
		}

		return [$moduleName , $controllerName , $actionName , $params];
	}

	/**
	 * 获取配置参数中的module、controller、action、param、filter
	 *
	 * @param  array  $urlParams
	 * @param  string $urlPatternOriginal
	 * @return array  [$moduleName , $controllerName , $action , $matches , $filter]
	 */
	private static function getMCAPFConfig($urlParams , $urlPatternOriginal){

		if (empty($urlParams['controller'])) 
			throw new RouteException('路由:' . $urlPatternOriginal . '缺少Controller参数');

		$MC = explode('\\', $urlParams['controller']);

		if (empty($MC[0]) || empty($MC[1]))
			throw new RouteException('路由:' . $urlPatternOriginal . 'Controller参数配置错误');

		if (empty($urlParams['action']))
			throw new RouteException('路由:' . $urlPatternOriginal . '缺少action参数');

		$moduleName     = $MC[0];
		$controllerName = $MC[1] . 'Controller';
		$actionName     = $urlParams['action'];
		$filter         = isset($urlParams['filter']) ? $urlParams['filter'] : [];

		array_shift($matches);

		return [$moduleName , $controllerName , $action , $matches , $filter];
	}

	/**
	 * url没有匹配到路由则根据/moudle/controller/action?k=v解析出module\controller\action
	 */
	private static function getMCADefault($url){

		$moduleName = $controllerName = $actionName = '';

		$urlPatternOriginal = '/^' . str_replace('\\' , '\\\\' , APP_ROOT) . '\/(\w+)\/(\w+)\/(\w+)';

		$getMCA = function($urlPattern) use ($url) {

			if (preg_match($urlPattern , $url , $matches)) {

				array_shift($matches);
				return $matches;
			}

			return FALSE;
		};

		if (is_array($appPostfixs = ConfigTools::app('URL_POSTFIX'))) {

			foreach ($appPostfixs as $appPostfix) {
				
				$urlPattern = $urlPatternOriginal . '.' . $appPostfix . '$/';
				
				if ($MCA = $getMCA($urlPattern)) {

					list($moduleName , $controllerName , $actionName) = $MCA;

					break;
				} 
			}
		} else {

			$urlPattern = $urlPatternOriginal . '/$';

			if ($MCA = $getMCA($urlPattern)) {

				list($moduleName , $controllerName , $actionName) = $MCA;

				break;
			}
		}

		return [$moduleName , $controllerName , $actionName , [] , []];
	}

	/**
	 * 生成url正则表达式
	 */
	private static function generateUrlPattern($urlPatternOriginal , $urlRequired){

		$urlPatternOriginal = preg_quote(trim($urlPatternOriginal) , '/');
		
		$urlPatternOriginal = str_replace('\{' , '{' , $urlPatternOriginal);
		$urlPatternOriginal = str_replace('\}' , '}' , $urlPatternOriginal);

		if (preg_match_all('/{(\w+)}/', $urlPatternOriginal , $matches)) {
			
			for ($i = 0 ; $i < count($matches[1]) ; $i++) {
				
				$paramPattern  = !empty($urlRequired[$matches[1][$i]]) ? $urlRequired[$matches[1][$i]] : '.+';
				
				$replacePattern = '(' . $paramPattern . ')';

				$urlPatternOriginal = str_replace($matches[0][$i] , $replacePattern , $urlPatternOriginal);
			}
		}

		return ['/^' . str_replace('\\' , '\\\\' , APP_ROOT) . $urlPatternOriginal . '$/' , !empty($matches[1]) ? $matches[1] : []];
	}

	private static function getRoutes(){

		return count(self::$routes) ? self::$routes : ConfigTools::getRoutes();
	}
}
?>