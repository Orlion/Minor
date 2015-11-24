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

	private static $routes = [];

	/**
	 * 获取url对应的module、controller、action、param、filter
	 *
	 * @param  string $url
	 * @return array  [$module,$controller,$action,$param,$filter]
	 */
	public static function MCAPF($url , $baseUrl){

		$url = parse_url(rawurldecode($url) , PHP_URL_PATH);

		return UrlAnalysis::getMCAPF($url , $baseUrl);
	}

	/**
	 * 生成url,将module/controller/action?key=value型url转为符合路由规则的url
	 *
	 * @param  string $urlOriginal fg: module/controller/action?key1=val2&key2=val3#key3=val3
	 * @return string $url
	 */
	public static function URL($urlOriginal){

		return UrlGenerator::generateUrl($urlOriginal);
	}

	public static function getRoutes(){

		return count(self::$routes) ? self::$routes : ConfigTools::getRoutes();
	}
}
?>