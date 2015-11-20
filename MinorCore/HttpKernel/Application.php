<?php
class Application{

	private static $request;

	private static $response;

	public static function getRequest(){

		return self::$request;
	}

	public static function getResponse(){

		return self::$response;
	}

	public static function setRequest(Request $request){

		self::$request = $request;
	}

	public static function setResponse(Response $resposne){

		self::$response = $response;
	}
}
?>