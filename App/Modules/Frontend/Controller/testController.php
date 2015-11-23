<?php

namespace App\Test;

use MinorCore\Controller\Controller;
use App\Lib\Mymailtool;
use MinorCore\View\View;
use MinorCore\Ioc\ServiceContainer;
use MinorCore\HttpKernel\Request;
use MinorCore\HttpKernel\Response;

class testController extends Controller{

	public function __construct(ServiceContainer $container , Request $request , Response $response){
		
	}

	public function index($username){
		
		$mymailt = new Mymailtool();

		return View::render('Test:index.tpl' , ['id' => 1]);
	}
}
?>