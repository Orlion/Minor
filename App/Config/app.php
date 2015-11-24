<?php
/**
 * Application Config
 */
return[
	
	// 应用名
	'APP_NAME'		=>	'Minor',
	// 编码
	'APP_CHARSET'	=>	'UTF-8',
	// 时区
	'APP_TIMEZONE'	=>	'PRC',

	// 是否开启DEBUG模式，即是否显示错误
	'DEBUG' 		=>	TRUE,
	// 系统错误页面
	'EXCEPTION_PAGE'=>	'500.html',
	// 请求错误页面
	'REQUEST_PAGE'	=>	'404.html',

	// url后缀
	'URL_POSTFIX'	=>	['html' , 'shtml' , 'htm'],

	// 是否缓存html
	'CACHE_HTML'			=>	TRUE,
	// html缓存时间
	'CACHE_HTML_TIME'		=>	3600,
];
?>