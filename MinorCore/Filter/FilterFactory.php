<?php
class FilterFactory(){

	public static function bulidFilter($filterName){

		$filterFile = __DIR__ . '/../../App/Filter/' . $filterName . 'Filter.php';

		if (!file_exists($filterFile)) 
			throw new FilterException('过滤器:' . $filterName . ',文件不存在');

		require $filterFile;

		if (class_exists($filterName . 'Filter'))
			throw new FilterException('过滤器:' . $filterName . ',类没有定义');

		if (!array_key_exists('Filter' , class_implements($filterName . 'Filter'))) 
			throw new FilterException('过滤器:' . $filterName . ',没有实现Filter接口');

		return new $filterName . 'Filter';
	}
}

?>