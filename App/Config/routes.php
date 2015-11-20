<?php
return [

	'/test/{id}.html'	=>	[
		'name'			=>	'test',
		'required'		=>	[
								'id'	=>	'\d+',
							],
		'controller'	=>	'Test\test',
		'action'		=>	'index',
	],
];
?>