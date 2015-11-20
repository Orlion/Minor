<?php
/**
 * 框架运转核心
 *
 * @package Minor
 * @author  Orlion <orlion@foxmail.com>
 */
class Core{

	public static function run(){

		$kernel = new \MinorCore\HttpKernel\Kernel();

		$request = $kernel->carry();

		$response = $kernel->handle($request);

		$kernel->outres($response);
	}
}
?>