<?php
class FilterChain{

	private $filterChain = [];

	public function __construct(Array $filterChain){

		$this->filterChain = $filterChain;
	}

	public function doFilter(Request $reqeust , Response $response){

		$filterName = array_shift($this->filterChain);

		if ($filterName) {
			// 如果过滤器链里还有没有执行的过滤器则执行过滤器doFilter方法
			$filter = FilterFactory::bulidFilter($filterName);

			$filter->doFilter(&$request , &$response , $this);
		} else {
			// 如果过滤器链里所有过滤器都执行过则返回
			// 如果某个过滤器没有执行FilterChain->doFilter()则不会执行到此，也就是该过滤器没有放行
			return [$reqeust , $response];
		}
	}
}
?>