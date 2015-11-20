<?php

namespace MinorCore\HttpKernel;

class HttpKernelException extends Exception{

	private $errmsg = 'HttpKernel异常';

	public function __construct($errmsg = ''){

		$errmsg && $this->errmsg = $errmsg;
	}
	public function getMessage(){

		return $this->errmsg;
	}
}
?>