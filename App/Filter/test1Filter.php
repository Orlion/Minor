<?php

namespace App\Filter;

use MinorCore\Filter\Filter;
use MinorCore\HttpKernel\Request;
use MinorCore\HttpKernel\Response;

class test1Filter implements Filter{

	public function doFilter(Request $request , Response $resposne){

		$request->setUrl('aaa');
	}
}
?>