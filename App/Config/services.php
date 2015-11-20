<?php
/**
 * 服务容器配置
 */
return [

'my_mailer_tool'=>	[
						'class'	=>	'App\\Lib\\Mymailtool',
					],
	
	'my_mailer'	=>	[
						'class'	=>	'App\\Lib\\Mymail',
						'parameters'	=>	['@my_mailer_tool' , 'testusername'],
					],
];
?>