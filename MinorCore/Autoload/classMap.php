<?php

$MinorCoreDir = dirname(__DIR__);
$baseDir = dirname($MinorCoreDir);

return [

	'Core'	=>	$MinorCoreDir . '/Core.php',

	'MinorCore\\HttpKernel\\Kernel'					=>	$MinorCoreDir . '/HttpKernel/Kernel.php',
	'MinorCore\\HttpKernel\\Request'				=>	$MinorCoreDir . '/HttpKernel/Request.php',
	'MinorCore\\HttpKernel\\Response'				=>	$MinorCoreDir . '/HttpKernel/Response.php',
	'MinorCore\\HttpKernel\\RequestFactory'			=>	$MinorCoreDir . '/HttpKernel/RequestFactory.php',
	'MinorCore\\HttpKernel\\ResponseFactory'		=>	$MinorCoreDir . '/HttpKernel/ResponseFactory.php',
	'MinorCore\\HttpKernel\\MinorCookie'			=>	$MinorCoreDir . '/HttpKernel/MinorCookie.php',
	'MinorCore\\HttpKernel\\MinorSession'			=>	$MinorCoreDir . '/HttpKernel/MinorSession.php',
	'MinorCore\\HttpKernel\\Application'			=>	$MinorCoreDir . '/HttpKernel/Application.php',
	'MinorCore\\HttpKernel\\HttpKernelException'	=>	$MinorCoreDir . '/HttpKernel/HttpKernelException.php',
	'MinorCore\\HttpKernel\\Kernel'					=>	$MinorCoreDir . '/HttpKernel/Kernel.php',

	'MinorCore\\Route\\Route'			=>	$MinorCoreDir . '/Route/Route.php',
	'MinorCore\\Route\\RouteException'	=>	$MinorCoreDir . '/Route/RouteException.php',

	'MinorCore\\Controller\\Controller'				=>	$MinorCoreDir . '/Controller/Controller.php',
	'MinorCore\\Controller\\ControllerException'	=>	$MinorCoreDir . '/Controller/ControllerException.php',

	'MinorCore\\Ioc\\ServiceContainer'	=>	$MinorCoreDir . '/Ioc/ServiceContainer.php',
	'MinorCore\\Ioc\\ServiceException'	=>	$MinorCoreDir . '/Ioc/ServiceException.php',
	'MinorCore\\Ioc\\ServiceFactory'	=>	$MinorCoreDir . '/Ioc/ServiceFactory.php',
	'MinorCore\\Ioc\\ServiceProvider'	=>	$MinorCoreDir . '/Ioc/ServiceProvider.php',

	'MinorCore\\Config\\ConfigTools'		=>	$MinorCoreDir . '/Config/ConfigTools.php',
	'MinorCore\\Config\\ConfigException'	=>	$MinorCoreDir . '/Config/ConfigException.php',

	'MinorCore\\File\\FileTools'		=>	$MinorCoreDir . '/File/FileTools.php',
	'MinorCore\\File\\FileException'	=>	$MinorCoreDir . '/File/FileException.php',

	'MinorCore\\View\\View'				=>	$MinorCoreDir . '/View/View.php',
	'MinorCore\\View\\ViewException'	=>	$MinorCoreDir . '/View/ViewException.php',
];
?>