<?php

namespace MinorCore\Filter;

use MinorCore\HttpKernel\Request;
use MinorCore\HttpKernel\Response;

interface Filter{

	public function doFilter(Request $request , Response $response);
	
}
?>