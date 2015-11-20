<?php

namespace MinorCore\HttpKernel;

class MinorCookie{

	private static $_minorcookie;

	private function __construct(){

	}

	private function __clone(){

	}

	public static function getMinorCookie(){

		if (is_null(self::$_minorcookie) || !self::$_minorcookie instanceof self) {

			self::$_minorcookie = new self();
		}

		return self::$_minorcookie;
	}

	public function getCookies(){

		return $_COOKIE;
	}

	public function getCookie($key , $default = ''){

		return isset($_COOKIE[$key]) ? $_COOKIE[$key] : $default;
	}

	public function setCookie($name , $value , $expire = 0 , $path = '' , $domain = '' , $secure = false , $httponly = false){

		setcookie($name , $value , $expire , $path , $domain , $secure);
	}

	public function delCookie($name){

		return setcookie($name) || setcookie($name , '' , now()-1);
	}
}
?>