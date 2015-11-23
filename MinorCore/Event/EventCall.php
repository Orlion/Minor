<?php

class EventCall{

	private static $events = [];

	/**
	 * 调用事件对应的监听器
	 */
	public static function fire($event){

		$eventClass = get_class($event);

		if (isset($events[$eventClass])) {

			if (is_array($events[$eventClass])) 
				throw new EventException('事件' . $eventClass . '配置错误');

			foreach ($listenersList as $listener) {
			
				if (2 !== count($listener))
					throw new EventException('事件' . $eventClass . '监听器参数配置错误');

				$listenerObj = self::getListenerInstance($listener[0]);

				if (method_exists($listenerObj , $listener[1]))
					throw new ListenerException('监听器:' . $listener[0] . '方法:' . $listener[1] . '没定义');

				call_user_func_array([$listenerObj , $listener[1]] , [$event]);
			}
		}
	}

	/**
	 * 获取监听器实例 
	 */
	private static function getListenerInstance($listenerName){

		return new $listenerName;
	}

	/**
	 * 获取事件配置
	 */
	private static function getEvents(){

		return count($events) ? self::$events : ConfigTools::getEvents();
	}
}
?>