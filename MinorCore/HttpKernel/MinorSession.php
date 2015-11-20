<?php

namespace MinorCore\HttpKernel;

class MinorSession{

	private static $_minorsession;
	
	private function __construct(){

	}

	private function __clone(){

	}

	public static function getMinorSession(){

		if (is_null(self::$_minorsession) || !self::$_minorsession instanceof self) {

			self::$_minorsession = new self();
		}

		return self::$_minorsession;
	}

	public function setSession($key , $value){

		$_SESSION[(string)$key] = $value;
	}

	public function getSession($key , $default = ''){

		return isset($_SESSION[(string)$key]) ? $_SESSION[$key] : $default;
	}

	public function delSession($key){

		unset($_SESSION[(string)$key]);
	}
}
?>