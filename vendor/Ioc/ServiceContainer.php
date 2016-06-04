<?php

namespace Minor\Ioc;

use Minor\Config\ConfigException;
use Minor\Framework\Context;

class ServiceContainer
{
    private static $_instance = NULL;

    private $serviceProviders = [];

    private function __construct()
    {
        $this->serviceProviders = Context::getConfig()->getProviders();
    }

    private function __clone(){}

    public static function getInstance()
    {
        if (is_null(self::$_instance) || !self::$_instance instanceof self) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function bind($serviceName, $service)
    {
        $this->set($serviceName, $service);
    }

    public function singleton($serviceName, $service)
    {
        $this->set($serviceName, $service, true);
    }

    public function get($serviceName)
    {
        return $this->build($serviceName);
    }

    private function build($serviceName)
    {
        if (empty($this->serviceProviders[$serviceName]))
            throw new ServiceException('服务提供者[' . $serviceName . ']:未注册到服务容器中');

        $serviceConfig = $this->serviceProviders[$serviceName];
        if (empty($serviceConfig['class']))
            throw new ConfigException('服务提供者[' . $serviceName . ']:缺少class配置');

        $serviceProvider = ServiceProviderBuilder::buildServiceProvider($this, $serviceName, $serviceConfig['class'], empty($serviceConfig['arguments']) ? [] : $serviceConfig['arguments']);

        if (isset($serviceConfig['singleton']) && $serviceConfig['singleton']) {
            $this->serviceProviders[$serviceName]['class'] = $serviceProvider;
        }

        return $serviceProvider;
    }

    private function set($serviceName, $service, $singleton = false)
    {
        $this->serviceProviders[$serviceName] = ['class' => $service, 'singleton' => $singleton];
    }
}