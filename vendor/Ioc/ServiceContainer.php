<?php

namespace Minor\Ioc;

use Minor\Config\ConfigException;

class ServiceContainer
{
    private static $_instance = NULL;

    private $providers = [];

    private function __construct(Array $providers)
    {
        $this->providers = $providers;
    }

    private function __clone(){}

    public static function getInstance(Array $providers)
    {
        if (is_null(self::$_instance) || !self::$_instance instanceof self) {
            self::$_instance = new self($providers);
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
        try {
            return $this->build($serviceName);
        } catch (ServiceException $se) {
            throw $se;
        } catch (ConfigException $ce) {
            throw $ce;
        }
    }

    private function build($serviceName)
    {
        if (empty($this->providers[$serviceName]))
            throw new ServiceException('服务提供者[' . $serviceName . ']:未注册到服务容器中');

        $serviceConfig = $this->providers[$serviceName];

        if (empty($serviceConfig['class']))
            throw new ConfigException('服务提供者[' . $serviceName . ']:缺少class配置');

        $serviceProvider = ServiceProviderBuilder::buildServiceProvider($this, $serviceName, $serviceConfig['class'], empty($serviceConfig['arguments']) ? [] : $serviceConfig['arguments']);

        if (isset($serviceConfig['singleton']) && $serviceConfig['singleton']) {
            $this->providers[$serviceName]['class'] = $serviceProvider;
        }

        return $serviceProvider;
    }

    private function set($serviceName, $service, $singleton = false)
    {
        $this->providers[$serviceName] = ['class' => $service, 'singleton' => $singleton];
    }
}
