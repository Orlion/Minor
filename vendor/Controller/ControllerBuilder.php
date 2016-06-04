<?php

namespace Minor\Controller;

use ReflectionClass;
use ReflectionException;

class ControllerBuilder
{
    public static function buildController($controllerName, $actionName)
    {
        try {
            $controllerClass = new ReflectionClass($controllerName);

            // 判断是否继承自Minor\Controller\Controller
            if ('Minor\Controller\Controller' != $controllerClass->getParentClass()->name)
                throw new ControllerException('自定义控制器[' . $controllerName . ']:必须继承自Minor\Controller\Controller');

            return [$controllerClass->newInstance(), self::getReflectionMethod($controllerClass, $controllerName, $actionName)];
        } catch (ReflectionException $re) {
            throw new ControllerException('自定义控制器[' . $controllerName . ']:实例化失败');
        }

        return null;
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