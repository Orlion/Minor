<?php

namespace MinorCore\Filter;

class FilterFactory{

	public static function bulidFilter($filterName){

		return new $filterName;
	}
}

?>