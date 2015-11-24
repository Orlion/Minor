<?php
/**
 * 获取一个控制器对象
 *
 * @package Minor
 * @author  Orlion <orlion@foxmail.com>
 */
namespace MinorCore\Controller;

use MinorCore\HttpKernel\Request;
use MinorCore\HttpKernel\Response;
use MinorCore\Ioc\ServiceContainer;
use ReflectionClass;

class ControllerFactory{

	private static $request;

	private static $response;

	private static $container;

	/**
	 * 获取一个控制器对象
	 *
	 * @param  string 			$moduleName
	 * @param  string 			$controllerName
	 * @param  string 			$action
	 * @param  array 			$params
	 * @param  Request 			$request
	 * @param  Response 		$response
	 * @param  ServiceContainer $container
	 * @return $ControllerName  $controllerObj
	 */
	public static function bulidController($moduleName , $controllerName , $actionName , Array $params , Request $request , Response $response , ServiceContainer $container){

		self::$request   = $request;
		self::$response  = $response;
		
		self::$container = $container;

		$controllerClassNameSpace = self::getControllerClassNameSpace($moduleName , $controllerName);

		$controllerClass = new ReflectionClass($controllerClassNameSpace);
		// 判断控制器参数是否与配置文件一致
		if (count($params) != self::getRequiereParamsNum($controllerClass , $controllerName , $actionName))
			throw new ControllerException('控制器' . $controllerName . '中方法' . $actionName . '参数个数不正确');

		// 判断是否继承自MinorCore\Controller\Controller
		if ('MinorCore\Controller\Controller' !== $controllerClass->getParentClass()->name) {

			throw new ControllerException('自定义控制器:' . $controllerClassNameSpace . '必须继承自MinorCore\Controller\Controller');
		}

		// 检查是否可实例
		if (!$controllerClass->isInstantiable()) {

			throw new ControllerException('控制器:' . $controllerClassNameSpace . '不可实例化');

		}

		// 获取构造函数
		$constrcutor = $controllerClass->getConstructor();

		// 取构造函数参数，通过ReflectionParameter数组返回参数列表
		$parameters = $constrcutor->getParameters();

		// 构造函数参数为空则直接实例化返回
		if (!count($parameters))
			return new $controllerClassNameSpace;
		// 递归解析构造函数的参数
		$dependencies = self::getDependencies($parameters);
		// 创建一个类的新实例，给出的参数将传递到类的构造函数
		return $controllerClass->newInstanceArgs($dependencies);
	}
	/**
	 * 通过模块名和控制器名获取该控制器的命名空间
	 *
	 * @param  string $moduleControllerName
	 * @return string $controllerClassNameSpace
	 */
	private static function getControllerClassNameSpace($moduleName , $controllerName){

		$controllerFile = __DIR__ .'/../../App/Modules/' . $moduleName . '/Controller/' . $controllerName . '.php';
		
		if (!file_exists($controllerFile)) 
			throw new ControllerException('控制器' . $moduleName . '\\' . $controllerName . '文件不存在');

		require $controllerFile;

		$controllerClassNameSpace = '\\App\\' . $moduleName . '\\' . $controllerName;
		if (!class_exists($controllerClassNameSpace))
			throw new ControllerException('控制器' . $controllerClassNameSpace . '不存在');

		return $controllerClassNameSpace;
	}

	/**
	 * 获取控制的依赖
	 *
	 * @param  Array $parameters
	 * @return Array $dependencies
	 */
	private static function getDependencies($parameters){

		$dependencies = [];

		foreach ($parameters as $parameter) {

			$dependeny = $parameter->getClass();

			if (is_null($dependeny)) {
				
				// 如果是变量，有默认值则设默认值
				$dependencies[] = self::$resolveNonClass($parameter);
			} else {

				switch ($dependeny->name) {

					case 'MinorCore\Ioc\ServiceContainer' : 
						$dependencies[] = self::$container;
						break;

					case 'MinorCore\HttpKernel\Request'	: 
						$dependencies[] = self::$request;
						break;

					case 'MinorCore\HttpKernel\Response' :
						$dependencies[] = self::$response;
						break;

					default :
						$dependencies[] = self::$container->getServiceByClass($parameter);
				}
			}
		}

		return $dependencies;
	}

	/**
	 * 获取控制器普通类型的参数
	 *
	 * @param  Parameter $parameter
	 * @return value     $value
 	 */
	private static function resolveNonClass($parameter){

		// 如果有默认值则返回默认值
		if ($parameter->isDefaultValueAvailable()) {
			return $parameter->getDefaultValue();
		}

		throw new ControllerException('控制器构造函数无法注入无默认值形参');
	}
	/**
	 * 获取类控制器中指定action的参数个数
	 *
	 * @param  ReflectionClass $class
	 * @param  string 		   $className
	 * @param  string 		   $actionName
	 */
	private static function getRequiereParamsNum($class , $className , $actionName){

		if (!$class->hasMethod($actionName))
			throw new ControllerException('控制器' . $className . '没有定义' . $actionName . '方法');

		$method = $class->getMethod($actionName);

		if (!$method->isPublic())
			throw new ControllerException('控制器' . $className . '中方法' . $actionName . '不是公开方法');
		
		return $method->getNumberOfRequiredParameters();

	}
}
?>