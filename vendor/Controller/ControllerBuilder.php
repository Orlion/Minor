<?php

namespace Minor\Controller;

use ReflectionClass;
use ReflectionException;

class ControllerBuilder
{
    public static function buildController($controllerName, $actionName, \Minor\Framework\App $app)
    {
        try {
            $controllerClass = new ReflectionClass($controllerName);

            if (!($constructor = $controllerClass->getConstructor()) || $constructor->getNumberOfRequiredParameters() > 1)
                throw new ControllerException('自定义控制器[' . $controllerName . ']:构造函数必须有且只有一个Minor\Framework\App参数');

            return [$controllerClass->newInstance($app), self::getReflectionMethod($controllerClass, $controllerName, $actionName)];
        } catch (ReflectionException $re) {
            throw new ControllerException('自定义控制器[' . $controllerName . ']:实例化失败');
        }
    }

    public static function getReflectionMethod(ReflectionClass $class , $className , $actionName)
    {
        if (!$class->hasMethod($actionName))
            throw new ControllerException('自定义控制器[' . $className . ']:没有定义' . $actionName . '方法');

        $method = $class->getMethod($actionName);

        if (!$method->isPublic())
            throw new ControllerException('自定义控制器[' . $className . ']:方法[' . $actionName . ']必须为public方法');

        return $method;
    }
}