<?php

namespace App\Filter;

use MinorCore\Filter\Filter;
use MinorCore\HttpKernel\Request;
use MinorCore\HttpKernel\Response;

class test2Filter implements Filter{

	public function doFilter(Request $request , Response $resposne){

		$request->setUrl('bbb');
	}
}
?>