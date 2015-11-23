<?php

namespace MinorCore\Event;

use ArrayAccess;

class Event implements ArrayAccess(){

	protected $elements;

	protected function offsetExists($offset){

		return isset($this->$elements[$offset]);
	}

	protected function offsetGet ($offset){

		return $this->elements[$offset];
	}

	protected function offsetSet ($offset, $value){

		$this->elements[$offset] = $value;
	}

	protected function offsetUnset ($offset){

		unset($this->elements[$offser]);
	}
}
?>