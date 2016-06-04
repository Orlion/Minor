<?php

namespace Minor\Ioc;

class ServiceProviderBuilder
{
    public static function buildServiceProvider($serviceContainer, $serviceName, $serviceClass, Array $arguments = [])
    {
        if ($serviceClass instanceof \Closure) {
            // 如果是闭包则执行并返回
            return $serviceClass();
        }

        if (is_object($serviceClass)) {
            // 如果是对象则直接返回
            return $serviceClass;
        }

        try {
            $reflectionClass = new \ReflectionClass($serviceClass);

            if (!$reflectionClass->hasMethod('boot'))
                throw new ServiceException('服务提供者[' . $serviceName . ']:未定义boot方法');

            $serviceProvider = $reflectionClass->newInstance();

            // 将参数中的'@xxx'(即对其他服务提供者的引用实例化)
            array_walk($arguments, function(&$argument) use($serviceContainer){
                if (0 === strpos($argument , '@')) {
                    $argument = $serviceContainer->get(ltrim($argument , '@'));
                }
            });

            $bootMethod = $reflectionClass->getMethod('boot');
            $bootMethod->invokeArgs($serviceProvider, $arguments);

            return $serviceProvider;
        } catch(\ReflectionException $re) {
            throw new ServiceException('服务提供者[' . $serviceName . ']:实例化失败');
        }
    }
}
