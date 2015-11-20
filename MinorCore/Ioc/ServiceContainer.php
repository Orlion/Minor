<?php
/**
 * 框架服务容器
 *
 * @package Minor
 * @author  Orlion <orlion@foxmail.com>
 */
namespace MinorCore\Ioc;

use Closure;

class ServiceContainer{

	private static $_container = NULL;

	private $containers = [];

	private $classServiceMap = [];

	private function __construct(){

	}

	private function __clone(){

	}

	public static function getServiceContainer(){

		if (is_null(self::$_container) || !self::$_container instanceof self) {

			self::$_container = new self();
		}

		return self::$_container;
	} 
	/**
	 * 注册服务
	 */
	public function set($serviceName , $serviceClass){

		$this->containers[$serviceName] = $serviceClass;
	}

	/**
	 * 获取服务
	 */
	public function get($serviceName){

		if (empty($this->containers[$serviceName])) {

			throw new ServiceException('服务:' . $serviceName . '未绑定到服务容器中');
		}

		return $this->bulid($this->containers[$serviceName]);
	}

	/**
	 * 绑定服务与类
	 */
	public function bind($class , $serviceName){

		$this->classServiceMap[$class] = $serviceName;
	}

	/**
	 * 通过类名获取服务
	 */
	public function getServiceByClass($class){

		if (empty($this->classServiceMap[$class])) {

			throw new ServiceException('类:' . $class . '未绑定到服务容器中');
		}

		return $this->get($this->classServiceMap[$class]);
	}

	/**
	 * 判断服务是否已存在
	 */
	public function has($serviceName){
		
		return isset($this->containers[$serviceName]);
	}
	/**
	 * 自动绑定自动解析
	 */
	private function bulid($className){

		if ($className instanceof Closure) {
			// 如果是闭包则执行并返回
			return $className($this);
		}

		if (is_object($className)) {
			// 如果是对象则直接返回
			return $className;
		}

		$class = new ReflectionClass($className);

		// 检查是否可实例
		if (!$class->isInstantiable()) {

			throw new ServiceException($className , '类不可实例化');
		}

		// 获取构造函数
		$constrcutor = $class->getConstructor();
		
		// 若没有构造函数则直接实例化返回
		if (is_null($constrcutor))
			return new $className;

		// 取构造函数参数，通过ReflectionParameter数组返回参数列表
		$parameters = $constrcutor->getParameters();
		// 递归解析构造函数的参数
		$dependencies = $this->getDependencies($parameters);
		// 创建一个类的新实例，给出的参数将传递到类的构造函数
		return $class->newInstanceArgs($dependencies);
	}
	/**
	 * @param  array $parameters
	 * @return array $dependencies
	 */
	private function getDependencies(Array $parameters){

		$dependencies = [];

		foreach ($parameters as $parameter) {

			$dependeny = $parameter->getClass();

			if (is_null($dependeny)) {
				// 如果是变量，有默认值则设默认值
				$dependencies[] = $this->resolveNonClass($parameter);
			} else {
				// 是类则递归解析
				$dependencies[] = $this->bulid($parameter);
			}
		}

		return $dependencies;
	}

	private function resolveNonClass($parameter){

		// 如果有默认值则返回默认值
		if ($parameter->isDefaultValueAvailable()) {
			return $parameter->getDefaultValue();
		}

		throw new ServiceException('获取服务失败,无法获取类构造函数参数');
	}
}
?>