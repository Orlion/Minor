<?php

namespace App\Index;

use MinorCore\Controller\Controller;
use MinorCore\View\View;

class indexController extends Controller{

	public function index(){

		return View::render('Index:index.index.tpl');
	}

}
?>