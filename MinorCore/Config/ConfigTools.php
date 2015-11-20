<?php

namespace MinorCore\Config;

class ConfigTools{

	private static $configMap = [
									'services'	=>	"{__DIR__}/../../App/Config/services.php",
									'routes'	=>	"{__DIR__}/../../App/Config/routes.php",
									'app'		=>	"{__DIR__}/../../App/Config/app.php",
								];

	public static function getServices(){

		if (!file_exists(self::$configMap['services']))
			throw new ConfigException('services配置文件不存在');

		return require self::$configMap['services'];
	}

	public static function getRoutes(){

		if (!file_exists(self::$configMap['services']))
			throw new ConfigException('routes配置文件不存在');

		return require self::$configMap['routes'];
	}
	
	public static function getApp(){

		if (!file_exists(self::$configMap['app']))
			throw new ConfigException('routes配置文件不存在');

		return require self::$configMap['app'];
	}

	public static function app($ConfigKey){

		$appConfig = self::getApp();

		if (!isset($appConfig[(string)$ConfigKey]))
			throw new ConfigException('app配置不存在"' . $ConfigKey . '"项');

		return $appConfig[(string)$ConfigKey];
	}
}
?>