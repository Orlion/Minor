<?php

namespace App\Lib;

class Mymail{
	function __construct(Mymailtool $mt , $username){

		$this->mt = $mt;
		$this->username = $username;
	}
}
?>