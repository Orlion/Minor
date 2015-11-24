<?php

namespace MinorCore\HttpKernel;

class Request{

	private static $_request = null;

	private $url;

	private $method;
	// 参数
	private $params;

	private $minorcookie;

	private $ip;

	private $os;

	private $browser;

	private $baseUrl;

	private function __construct(){

	}

	private function __clone(){

	}

	public static function getRequest(){

		if (is_null(self::$_request) || !self::$_request instanceof self) {

			self::$_request = new self();
		}

		return self::$_request;
	}

	public function getUrl(){
		return $this->url;
	}
	/**
	 * eg: /Minor/Public/
	 */
	public function getBaseUrl(){
		return $this->baseUrl;
	}

	public function getMethod(){
		return $this->method;
	}

	public function getParams(){
		return $this->params;
	}

	public function getParameter($key , $default = ''){
		return isset($this->params[$key]) ? $this->params[$key] : $default;
	}

	public function getMinorCookie(){
		return $this->minorcookie;
	}

	public function getIp(){
		return $this->ip;
	}

	public function getOs(){
		return $this->os;
	}

	public function getBrowser(){
		return $this->browser;
	}

	public function getServer($server){
		return $_SERVER[(string)$server];
	}

	public function setUrl($url){
		$this->url = $url;
	}

	public function setBaseUrl($baseUrl){
		$this->baseUrl = $baseUrl;
	}

	public function setMethod($method){
		$this->method = $method;
	}

	public function setParams(Array $params){
		$this->params = $params;
	}

	public function setParameter($key , $value){
		
		$this->params[$key] = $value;
	}

	public function setMinorCookie(MinorCookie $minorcookie){
		$this->minorcookie = $minorcookie;
	}

	public function setIp($ip){
		$this->ip = $ip;
	}

	public function setOs($os){
		$this->os = $os;
	}

	public function setBrowser($browser){
		$this->browser = $browser;
	}

	public function redirect($url , $httpStatusCode = 301){

		!in_array($httpStatusCode , [301 , 302]) && $httpStatusCode = 301;

		header('HTTP/1.1 ' . $httpStatusCode . ' Moved Permanently');

		exit(header('location:' . $url));
	}

	public function forward($url){
		
		$this->setUrl($url);

		$kernel = new Kernel();
		$response = $kernel->handle($this);
		$kernel->outres($response);
	}
}

?>