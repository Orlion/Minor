<?php
/**
 * 初始化服务容器,将配置文件中的服务映射到服务容器中
 *
 * @package Minor
 * @author  Orlion <orlion@foxmail.com>
 */
namespace MinorCore\Ioc;

use MinorCore\Config\ConfigTools;
use MinorCore\Config\ConfigException;
use ReflectionClass;

class ServiceFactory{

	private static $services = [];

	private static $container;

	/**
	 * 加载配置文件中所有服务初始化服务容器
	 */
	public static function bulidServerContainer(){

		self::$services   = ConfigTools::getServices();
		self::$container = ServiceContainer::getServiceContainer();

		foreach (self::$services as $serviceName => $serviceParam) {
			
			if (!self::$container->has($serviceName)) {

				self::$container->set($serviceName , function() use ($serviceName){

					return self::getInstance($serviceName , True);
				});

				self::$container->bind($serviceParam['class'] , $serviceName);
			}

		}

		return self::$container;
	}

	public static function getInstance($serviceName , $isSelf = TRUE){

		if (!$isSelf && self::$container->has($serviceName)) {

			return self::$container->get($serviceName);
		}

		$service = new ReflectionClass(self::$services[$serviceName]['class']);

		// 检查是否可实例
		if (!$service->isInstantiable()) {

			throw new ServiceException($serviceName , '不可实例化');
		}

		// 获取构造函数
		$constrcutor = $service->getConstructor();

		// 若没有构造函数则直接实例化返回
		if (is_null($constrcutor)) {

			if (!empty(self::$services[$serviceName]['parameters']) && count(self::$services[$serviceName]['parameters'])) {

				// 配置文件中存在参数与实际服务冲突抛出异常
				throw new ConfigException("服务:" . $serviceName . '构造函数不存在，参数应为空');
			}

			return new self::$services[$serviceName]['class'];
		}

		// 取构造函数参数，通过ReflectionParameter数组返回参数列表
		$parameters = $constrcutor->getParameters();

		if (count($parameters)) {

			// 递归解析构造函数的参数
			$dependencies = self::getDependencies($parameters , $serviceName);
			// 创建一个类的新实例，给出的参数将传递到类的构造函数
			return $service->newInstanceArgs($dependencies);
		} else {

			if (!empty(self::$services[$serviceName]['parameters']) && count(self::$services[$serviceName]['parameters'])) {

				throw new ConfigException("服务:" . $serviceName . '参数应为空');
			}

			return new self::$services[$serviceName]['class'];
		}
	}

	/**
	 * @param  array $parameters
	 * @return array $dependencies
	 */
	private static function getDependencies(Array $parameters , $serviceName){

		$paramsNum = count($parameters);

		if (!is_array(self::$services[$serviceName]['parameters']) || $paramsNum != count(self::$services[$serviceName]['parameters'])) {
			
			// 参数数量不统一抛出异常
			throw new ConfigException('服务:' . $serviceName . '配置参数异常');
		}

		$dependencies = [];

		for ($i = 0 ; $i < $paramsNum; $i++) {

			$dependeny = $parameters[$i]->getClass();

			$deService = self::getDeService(self::$services[$serviceName]['parameters'][$i]);

			if (is_null($dependeny)) {
				// 参数是常量则直接赋值
				if ($deService) {

					throw new ConfigException('服务:' . $servieName . '配置第' . $i . '个参数类型错误');
				}

				$dependencies[] = self::$services[$serviceName]['parameters'][$i];
			} else {

				// 参数是class则获取其实例
				if (self::$services[$deService]['class'] != $dependeny->name) {

					throw new ConfigException('服务:' . $serviceName . '配置第' . $i . '个参数类型错误');
				}

				$dependencies[] = self::getInstance($deService , FALSE);
			}
		}

		return $dependencies;
	}

	/**
	 * 判断参数是否是一个服务
	 */
	private static function getDeService($parameter){

		$deService = FALSE;

		if (strpos($parameter , '@') === 0) {

			$deService = ltrim($parameter , '@');

			if (empty(self::$services[$deService])) {

				throw new ConfigException('服务:' . $deService . '不存在');
			} 

			if (empty(self::$services[$deService]['class'])) {

				throw new ConfigException('服务:' . $deService . '缺少class参数');	
			}
		} 

		return $deService;
	}
}
?>