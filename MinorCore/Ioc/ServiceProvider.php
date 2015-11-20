<?php

namespace MinorCore\Ioc;

interface ServiceProvider{

	// 通过__get方法获取属性
	public function __get($name);

	// 通过__set方法注入构造复杂的对象
	public function __set($name , $value);
}
?>