<?php
/**
 * 框架控制器
 *
 * @package Minor
 * @author  Orlion <orlion@foxmail.com>
 */
namespace MinorCore\Controller;

use MinorCore\HttpKernel\Request;
use MinorCore\HttpKernel\Response;
use MinorCore\Ioc\ServiceContainer;

class Controller{

	protected $request = null;

	protected $response = null;

	protected $container = null;

	public function __construct(Request $request , Response $response , ServiceContainer $container){

		$this->request  = $request;

		$this->response = $response;

		$this->container = $container;
	}
}
?>