<?php

namespace Minor\HttpKernel;

class MinorSession
{

	private static $_instance;
	
	private function __construct()
	{
		session_start();
	}

	private function __clone(){}

	public static function getInstance()
	{
		if (is_null(self::$_instance) || !self::$_instance instanceof self) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function setSession($key , $value)
	{
		$_SESSION[(string)$key] = $value;
	}

	public function getSession($key , $default = '')
	{
		return isset($_SESSION[(string)$key]) ? $_SESSION[$key] : $default;
	}

	public function delSession($key)
	{
		unset($_SESSION[(string)$key]);
	}
}