<?php
/**
 * 框架运转核心
 *
 * @package Minor
 * @author  Orlion <orlion@foxmail.com>
 */
class Core{

	public static function run(){
		// 初始化内核
		$kernel = new \MinorCore\HttpKernel\Kernel();
		// carry 请求
		$request = $kernel->carry();
		// 对请求作出响应
		$response = $kernel->handle($request);
		// 返回响应内容
		$kernel->outres($response);
	}
}
?>