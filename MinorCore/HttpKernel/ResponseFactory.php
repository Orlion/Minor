<?php

namespace MinorCore\HttpKernel;

class ResponseFactory{

	public static function bulidResponse(){

		$response = Response::getResponse();
		$response->setMinorSession(self::getSession());

		return $response;
	}

	public static function getSession(){

		return MinorSession::getMinorSession();
	}
}
?>