<?php

namespace MinorCore\Filter;

interface Filter{

	public function doFilter(Request $request , Response $response , FiterChain $chain){}
	
}
?>