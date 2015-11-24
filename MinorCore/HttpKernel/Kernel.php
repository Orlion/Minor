<?php
/**
 * 框架HttpKernel
 *
 * @package Minor
 * @author  Orlion <orlion@foxmail.com>
 */
namespace MinorCore\HttpKernel;

use MinorCore\Route\Route;
use MinorCore\Ioc\ServiceFactory;
use MinorCore\Controller\ControllerFactory;
use MinorCore\Filter\FilterChain;

class Kernel{

	/**
	 * 请求对象
	 *
	 * @var MinorCore\HttpKernel\Request
	 */
	private $request;

	/**
	 * 响应对象
	 *
	 * @var MinorCore\HttpKernel\Response
	 */
	private $response;

	/**
	 * 服务容器对象
	 *
	 * @var MinorCore\Ioc\ServiceContainer
	 */
	private $container;
	
	/**
	 * 内核获取请求，初始化Request对象
	 *
	 * @return \MinorCore\HttpKernel\Request $request
	 */
	public function carry(){

		return RequestFactory::bulidRequest();
	}

	/**
	 * 内核处理请求并做出响应
	 *
	 * @param  \MinorCore\HttpKernel\Request  $request
	 * @return \MinorCore\HttpKernel\Response $response
	 */
	public function handle(Request $request){

		$this->request   = $request;

		$this->container = ServiceFactory::bulidServerContainer();

		$this->response  = ResponseFactory::bulidResponse();

		$url = $this->request->getUrl();

		$baseUrl = $this->request->getBaseUrl();

		list($moduleName , $controllerName , $actionName , $params , $filter) = Route::MCAPF($url , $baseUrl);

		$chain = new FilterChain($filter);

		$chain->doFilter($this->request , $this->response);

		$controller = ControllerFactory::bulidController($moduleName , $controllerName , $actionName , $params , $this->request , $this->response , $this->container);

		if (!method_exists($controller , $actionName))
			throw new ControllerException('控制器:' . $moduleControllerName . '未定义' . $actionName . '方法');
		// 调用控制器方法获取输出内容
		$content = call_user_func_array([$controller , $actionName] , $params);

		$this->response->addContent((string)$content);

		return $this->response;
	}

	/**
	 * 内核输出响应
	 *
	 * @param  Response $response
	 * @return void
	 */
	public function outres(Response $response){

		exit(($response instanceof Response) ? $response->outContent() : '');
	}
}
?>