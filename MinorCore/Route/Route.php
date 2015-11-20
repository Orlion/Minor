<?php
/**
 * 路由
 *
 * @package Minor
 * @author  Orlion <orlion@foxmail.com>
 */
namespace MinorCore\Route;

use MinorCore\Config\ConfigTools;

class Route{

	public static function getControllerAndAction($url){

		$moduleName = $controllerName = $actionName = ''; $params = [];

		$url = parse_url(rawurldecode($url) , PHP_URL_PATH);

		$routes = ConfigTools::getRoutes();

		foreach ($routes as $urlPatternOriginal => $urlParams) {
			
			list($urlPattern , $paramsKey) = self::generateUrlPattern($urlPatternOriginal , !empty($urlParams['required']) ? $urlParams['required'] : []);
			
			if (preg_match($urlPattern , $url , $matches)) {

				if (empty($urlParams['controller'])) 
					throw new RouteException('路由:' . $urlPatternOriginal . '缺少Controller参数');

				$moduleControllerArray = explode('\\', $urlParams['controller']);

				if (empty($moduleControllerArray[0]) || empty($moduleControllerArray[1]))
					throw new RouteException('路由:' . $urlPatternOriginal . 'Controller参数配置错误');

				$moduleName     = $moduleControllerArray[0];
				$controllerName = $moduleControllerArray[1] . 'Controller';

				if (empty($urlParams['action']))
					throw new RouteException('路由:' . $urlPatternOriginal . '缺少action参数');

				$actionName = $urlParams['action'];

				array_shift($matches);
				$params = $matches;
				
				break;
			}
		}

		if (empty($moduleName) || empty($controllerName) || empty($actionName)) {

			list($moduleName , $controllerName , $actionName) = self::getControllerAndActionDefault($url);

			if (empty($moduleName) || empty($controllerName) || empty($actionName)) 
				throw new RouteException("404");
		}

		return [$moduleName , $controllerName , $actionName , $params];
	}

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

		return ['/^' . str_replace('/' , '\/' , APP_ROOT) . $urlPatternOriginal . '$/' , !empty($matches[1]) ? $matches[1] : []];
	}

	private static function getControllerAndActionDefault($url){

		$moduleName = $controllerName = $actionName = '';

		$urlPatternOriginal = '/^' . str_replace('/' , '\/' , APP_ROOT) . '\/(\w+)\/(\w+)\/(\w+)';

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

		return [$moduleName , $controllerName , $actionName];
	}

	/**
	 * 生成url,将module/controller/action?key=value型url转为符合路由规则的url
	 *
	 * @param  string $urlOriginal fg: module/controller/action?key1=val2&key2=val3#key3=val3
	 * @return string $url
	 */
	public static function generateUrl($urlOriginal){

		$urlOriginalArray = parse_url(trim($urlOriginal));

		$routes = ConfigTools::getRoutes();

		$moduleControllerAction = explode('/', !empty($urlOriginalArray['path']) ? $urlOriginalArray['path'] : '');

		if (!empty($moduleControllerAction[0]) && !empty($moduleControllerAction[1]) && !empty($moduleControllerAction[2])) {

			foreach ($routes as $routePatternOriginal => $routeParams) {

				if (!empty($routeParams['controller']) && $routeParams['controller'] === ($moduleControllerAction[0] . '\\' . $moduleControllerAction[1]) && !empty($routeParams['action']) && $routeParams['action'] === $controllerAction[2]) {

					if (!empty($urlOriginalArray['query'])) {

						$replace = function ($paramVal , $paramKey) use (&$routePatternOriginal){

							if (strstr($routePatternOriginal , '{' . $paramKey . '}')) {

								$routePatternOriginal = str_replace('{' . $paramKey . '}' , $paramVal , $routePatternOriginal);
							} else {

								$routePatternOriginal .= (strstr($routePatternOriginal , '?') ? '&' : '?') . $paramKey . '=' . $paramVal;
							}
						};

						parse_str($urlOriginalArray['query'] , $queryArr);
						array_walk($queryArr , $replace);

						return  preg_match('/{(\w+)}/', $routePatternOriginal) ? $urlOriginal : $routePatternOriginal . (!empty($urlOriginalArray['fragment']) ? '#' . $urlOriginalArray['fragment'] : '');
					}
				}
			}
		}

		return $urlOriginal;
	}
}
?>