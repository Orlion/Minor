<?php

namespace MinorCore\Filter;

class FilterChain{

	private $filterChain = [];

	public function __construct(Array $filterChain){

		$this->filterChain = $filterChain;
	}

	public function doFilter(\MinorCore\HttpKernel\Request $request , \MinorCore\HttpKernel\Response $response){

		while (null !== $filterName = array_shift($this->filterChain)) {

			$filter = FilterFactory::bulidFilter($filterName);

			$filter->doFilter($request , $response);
		
		}
	}
}
?>