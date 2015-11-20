<?php

namespace MinorCore\HttpKernel;

class Response{

	private static $_response = null;

	private $minorsession;

	private $content = '';

	private function __construct(){

	}

	private function __clone(){

	}

	public static function getResponse(){

		if (is_null(self::$_response) || !self::$_response instanceof self) {

			self::$_response = new self();
		}

		return self::$_response;
	}

	public function setMinorSession(MinorSession $minorsession){

		$this->minorsession = $minorsession;
	}

	public function getMinorSession(){

		return $this->minorsession;
	}

	public function setHeader($header){

		header((string)$header);
	}

	public function setContent($content){

		$this->content = (string)$content;
	}

	public function addContent($content){

		$this->content .= (string)$content;
	}

	public function addHeadContent($content){

		$this->content = (string)$content . $this->content;
	}

	public function addFootContent($content){

		$this->content .= (string)$content;
	}

	public function getContent(){

		return (string)$this->content;
	}

	public function outContent(){

		echo $this->getContent();
	}

	public function __toString(){

		return (string)$this->content;
	}
}
?>