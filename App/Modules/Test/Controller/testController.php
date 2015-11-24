<?php

namespace App\Test;

use MinorCore\Controller\Controller;
use MinorCore\View\View;
use MinorCore\Ioc\ServiceContainer;
use MinorCore\HttpKernel\Request;
use MinorCore\HttpKernel\Response;

class testController extends Controller{

	public function __construct(ServiceContainer $container , Request $request , Response $response){
		
	}

	public function index($id){

		$my = new \Lib\Mymailtool();

		$event = new \App\Event\testEvent();
		$event['test'] = 'test';

		\MinorCore\Event\EventNotify::fire($event);

		return View::render('Test:test.index.tpl' , ['id' => $id]);
	}
}
?>