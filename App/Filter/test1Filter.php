<?php
class test1Filter implements Filter{

	public function doFilter(Request $request , Response $resposne , FilterChain $chain){

		$chain->doFilter();
	}
}
?>