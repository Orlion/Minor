<?php 

namespace MinorCore\Autoload;
/**
 * 自动加载类
 *
 * @package Minor
 * @author  Orlion <orlion@foxmail.com>
 */
class Autoload{

	public static function init(){

		require 'ClassLoader.php';
		spl_autoload_register('MinorCore\Autoload\ClassLoader::loader' , true);
	}
}

Autoload::init();
?>