<?php

namespace App\Listener;

class testListener{

	public function test(Event $event){

		echo $event['test'];
	}
}
?>