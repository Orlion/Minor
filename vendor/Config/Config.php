<?php
/**
 * Config
 */
namespace Minor\Config;

class Config
{
    private static $config = [];

    public static function init(Array $config)
    {
        self::$config = $config;
    }

    public static function get(Array $config, $default = null)
    {
        $key = key($config);

        return isset(self::$config[$key][$config[$key]]) ? self::$config[$key][$config[$key]] : $default;
    }

    public static function set(Array $config, $value)
    {
        $key = key($config);

        return self::$config[$key][$config[$key]] = $value;
    }
}