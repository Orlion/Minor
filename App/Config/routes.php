<?php
return [

	'/test/{id}.html'	=>	[
		'name'			=>	'test',
		'required'		=>	[
								'id'	=>	'\d+',
							],
		'controller'	=>	'Test\test',
		'action'		=>	'index',
		'filter'		=>	['Test\test1' , 'Test\test2'],
	],
];

?>