<?php

$MinorCoreDir = dirname(__DIR__);
$baseDir = dirname($MinorCoreDir);

return [

	'MinorCore\\Config\\ConfigTools'		=>	$MinorCoreDir . '/Config/ConfigTools.php',
	'MinorCore\\Config\\ConfigException'	=>	$MinorCoreDir . '/Config/ConfigException.php',

	'MinorCore\\Controller\\Controller'				=>	$MinorCoreDir . '/Controller/Controller.php',
	'MinorCore\\Controller\\ControllerException'	=>	$MinorCoreDir . '/Controller/ControllerException.php',
	'MinorCore\\Controller\\ControllerFactory'		=>	$MinorCoreDir . '/Controller/ControllerFactory.php',

	'MinorCore\\Event\\Event'				=>	$MinorCoreDir . '/Event/Event.php',
	'MinorCore\\Event\\EventNotify'			=>	$MinorCoreDir . '/Event/EventNotify.php',
	'MinorCore\\Event\\EventException'		=>	$MinorCoreDir . '/Event/EventException.php',
	'MinorCore\\Event\\ListenerException'	=>	$MinorCoreDir . '/Event/ListenerException.php',

	'MinorCore\\Event\\Event'		=>	$MinorCoreDir . '/Event/Event.php',
	'MinorCore\\Event\\EventCall'	=>	$MinorCoreDir . '/Event/EventCall.php',

	'MinorCore\\File\\FileTools'		=>	$MinorCoreDir . '/File/FileTools.php',
	'MinorCore\\File\\FileException'	=>	$MinorCoreDir . '/File/FileException.php',

	'MinorCore\\Filter\\Filter'					=>	$MinorCoreDir . '/Filter/Filter.php',
	'MinorCore\\Filter\\FilterChain'			=>	$MinorCoreDir . '/Filter/FilterChain.php',
	'MinorCore\\Filter\\FilterException'		=>	$MinorCoreDir . '/Filter/FilterException.php',
	'MinorCore\\Filter\\FilterFactory'			=>	$MinorCoreDir . '/Filter/FilterFactory.php',

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

	'MinorCore\\Ioc\\ServiceContainer'	=>	$MinorCoreDir . '/Ioc/ServiceContainer.php',
	'MinorCore\\Ioc\\ServiceException'	=>	$MinorCoreDir . '/Ioc/ServiceException.php',
	'MinorCore\\Ioc\\ServiceFactory'	=>	$MinorCoreDir . '/Ioc/ServiceFactory.php',
	'MinorCore\\Ioc\\ServiceProvider'	=>	$MinorCoreDir . '/Ioc/ServiceProvider.php',

	'MinorCore\\Route\\Route'			=>	$MinorCoreDir . '/Route/Route.php',
	'MinorCore\\Route\\RouteException'	=>	$MinorCoreDir . '/Route/RouteException.php',
	'MinorCore\\Route\\UrlAnalysis'		=>	$MinorCoreDir . '/Route/UrlAnalysis.php',
	'MinorCore\\Route\\UrlGenerator'	=>	$MinorCoreDir . '/Route/UrlGenerator.php',

	'MinorCore\\View\\View'				=>	$MinorCoreDir . '/View/View.php',
	'MinorCore\\View\\ViewException'	=>	$MinorCoreDir . '/View/ViewException.php',

	'Core'	=>	$MinorCoreDir . '/Core.php',
];
?>