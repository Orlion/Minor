<?php

namespace Minor\Event;

use Minor\Config\ConfigException;

class EventManager
{
    private static $events = [];

    public static function init(Array $events)
    {
        self::$events = $events;
    }

    public static function fire(Event $event)
    {
        $eventClass = get_class($event);

        if (!empty(self::$events[$eventClass])) {

            if (!is_array(self::$events[$eventClass]))
                throw new ConfigException('事件[' . $eventClass . ']配置错误,配置必须是数组');

            try {
                foreach (self::$events[$eventClass] as $listenerName => $methodName) {
                    self::invoke($listenerName, $methodName, $event);
                }
            } catch (ListenerException $le) {
                throw $le;
            }
        }
    }

    private static function invoke($listenerName, $methodName, Event $event)
    {
        list($listener, $method) = ListenerBuilder::buildListener($listenerName, $methodName);
        try {
            return $method->invoke($listener, $event);
        } catch (ReflectionException $re) {
            throw new ListenerException('自定义监听器[' . $listenerName . ']:方法[' . $methodName . ']执行失败，请检查配置文件');
        }
    }
}