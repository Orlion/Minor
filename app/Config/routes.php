<?php
return [
    '/'					=>	[
        'name'			    =>	'index',
        'controller'	    =>	'App\Modules\Index\Controller\IndexController',
        'action'		    =>	'index',
    ],
    '/demo/{productName}'            =>  [
        'name'			    =>	'test1',
        'controller'	    =>	'App\Modules\Demo\Controller\FooController',
        'action'		    =>	'bar',
        'required'          =>  ['productName' => '\w+'],
    ],
];
