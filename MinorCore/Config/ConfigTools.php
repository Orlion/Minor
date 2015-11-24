<?php

namespace MinorCore\Config;

class ConfigTools{

	private static $configMap = [
									'services'	=>	"{__DIR__}/../../App/Config/services.php",
									'routes'	=>	"{__DIR__}/../../App/Config/routes.php",
									'apps'		=>	"{__DIR__}/../../App/Config/app.php",
									'events'	=>	"{__DIR__}/../../App/Config/events.php",
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
	
	public static function getApps(){

		if (!file_exists(self::$configMap['apps']))
			throw new ConfigException('routes配置文件不存在');

		return require self::$configMap['apps'];
	}

	public static function app($ConfigKey){

		$appConfig = self::getApps();

		if (!isset($appConfig[(string)$ConfigKey]))
			throw new ConfigException('app配置不存在"' . $ConfigKey . '"项');

		return $appConfig[(string)$ConfigKey];
	}

	public static function getEvents(){

		if (!file_exists(self::$configMap['events']))
			throw new ConfigException('events配置文件不存在');

		return require self::$configMap['events'];
	}
}
?>