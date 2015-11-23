<?php
/**
 * 获取一个控制器对象
 *
 * @package Minor
 * @author  Orlion <orlion@foxmail.com>
 */
namespace MinorCore\Controller;

class RequestFactory{

	public static function bulidController($moduleName , $controllerName){

		$controllerClassNameSpace = $this->getControllerClassNameSpace($moduleName , $controllerName);

		$controllerClass = new ReflectionClass($controllerClassNameSpace);

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
		$dependencies = $this->getDependencies($parameters);
		// 创建一个类的新实例，给出的参数将传递到类的构造函数
		return $controllerClass->newInstanceArgs($dependencies);
	}
	/**
	 * 通过模块名和控制器名获取该控制器的命名空间
	 *
	 * @param  string $moduleControllerName
	 * @return string $controllerClassNameSpace
	 */
	private function getControllerClassNameSpace($moduleName , $controllerName){

		$controllerFile = __DIR__ .'/../../App/Modules/' . $moduleName . '/Controller/' . $controllerName . '.php';
		if (!file_exists($controllerFile)) 
			throw new ControllerException('控制器' . $moduleName . '\\' . $controllerName . '文件不存在');

		require_once $controllerFile;

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
	private function getDependencies($parameters){

		$dependencies = [];

		foreach ($parameters as $parameter) {

			$dependeny = $parameter->getClass();

			if (is_null($dependeny)) {
				
				// 如果是变量，有默认值则设默认值
				$dependencies[] = $this->resolveNonClass($parameter);
			} else {

				switch ($dependeny->name) {

					case 'MinorCore\Ioc\ServiceContainer' : 
						$dependencies[] = $this->container;
						break;

					case 'MinorCore\HttpKernel\Request'	: 
						$dependencies[] = $this->request;
						break;

					case 'MinorCore\HttpKernel\Response' :
						$dependencies[] = $this->response;
						break;

					case 'MinorCore\HttpKernel\Kernel' :
						$dependencies[] = $this;
						break;

					default :
						$dependencies[] = $this->container->getServiceByClass($parameter);
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
	private function resolveNonClass($parameter){

		// 如果有默认值则返回默认值
		if ($parameter->isDefaultValueAvailable()) {
			return $parameter->getDefaultValue();
		}

		throw new ControllerException('控制器构造函数无法注入无默认值形参');
	}
}
?>