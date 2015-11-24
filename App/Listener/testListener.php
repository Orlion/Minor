<?php

namespace App\Listener;

class testListener{

	public function handle(\App\Event\testEvent $event){

		echo $event['test'];
	}
}
?>