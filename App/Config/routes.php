<?php
return [

	'/'					=>	[
							'name'			=>	'index',
							'controller'	=>	'index/index',
							'action'		=>	'index',
							],

	'/test/{id}.html'	=>	[
							'name'			=>	'test',
							'required'		=>	[
												'id'	=>	'\d+',
												],
							'controller'	=>	'Test/test',
							'action'		=>	'index',
							'filter'		=>	['App\Filter\test1Filter' , 'App\Filter\test2Filter'],
							],
];

?>