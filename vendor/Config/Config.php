<?php

namespace Minor\Config;

class Config
{
    private static $_instance;

    private $configArr = [];

    private function __construct()
    {
        if (!is_file(APP_DIR . 'Config/providers.php')) {
            throw new ConfigException('services配置不存在');
        }

        if (!is_file(APP_DIR . 'Config/routes.php')) {
            throw new ConfigException('routes配置不存在');
        }

        if (!is_file(APP_DIR . 'Config/events.php')) {
            throw new ConfigException('events配置不存在');
        }

        if (!is_file(APP_DIR . 'Config/app.php')) {
            throw new ConfigException('app配置不存在');
        }

        $this->configArr = [
            'providers' => require APP_DIR . 'Config/providers.php',
            'routes'    => require APP_DIR . 'Config/routes.php',
            'events'    => require APP_DIR . 'Config/events.php',
            'app'       => require APP_DIR . 'Config/app.php'
        ];
    }

    private function __clone(){}

    public static function getInstance()
    {
        if (is_null(self::$_instance) || !self::$_instance instanceof self) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function getProviders()
    {
        return $this->configArr['providers'];
    }

    public function getRoutes()
    {
        return $this->configArr['routes'];
    }

    public function getEvents()
    {
        return $this->configArr['events'];
    }

    public function getApp()
    {
        return $this->configArr['app'];
    }
}