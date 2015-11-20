<?php

namespace MinorCore\File\FileException;

class FileException extends Exception{

	private $errmsg = '文件操作异常';

	public function __construct($errmsg){

		$this->errmsg = $errmsg;
	}
	public function getMessage(){

		return $this->errmsg;
	}
}
?>