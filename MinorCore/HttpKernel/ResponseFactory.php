<?php

namespace MinorCore\HttpKernel;

class ResponseFactory{

	public static function bulidResponse(){

		$response = Response::getResponse();
		$response->setMinorSession(self::getSession());
		$response->setCharset(self::getCharset());

		return $response;
	}

	public static function getSession(){

		return MinorSession::getMinorSession();
	}

	public static function getCharset(){

		return \MinorCore\Config\ConfigTools::app('APP_CHARSET');
	}
}
?>