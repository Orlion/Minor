<?php
/**
 * 获取一个监听器对象
 *
 * @package Minor
 * @author  Orlion <orlionml@gmail.com>
 */
namespace Minor\Event;

use ReflectionClass;
use ReflectionException;

class ListenerBuilder
{
    public static function buildListener($listenerName, $methodName)
    {
        try {
            $listenerClass = new ReflectionClass($listenerName);

            // 判断是否继承自Minor\Event\Listener
            if (false === ($parentClass = $listenerClass->getParentClass()) || 'Minor\Event\Listener' != $parentClass->name)
                throw new ListenerException('自定义监听器[' . $listenerName . ']:必须继承自Minor\Event\Listener');

            return [$listenerClass->newInstance(), self::getReflectionMethod($listenerClass, $listenerName, $methodName)];
        } catch (ReflectionException $re) {
            throw new ListenerException('自定义监听器[' . $listenerName . ']:实例化失败');
        }
    }

    public static function getReflectionMethod(ReflectionClass $class , $className , $methodName)
    {
        if (!$class->hasMethod($methodName))
            throw new ListenerException('自定义监听器[' . $className . ']:方法[' . $methodName . ']未定义');

        $method = $class->getMethod($methodName);

        if (!$method->isPublic())
            throw new ListenerException('自定义监听器[' . $className . ']:方法[' . $methodName . ']必须为public方法');

        return $method;
    }
}
