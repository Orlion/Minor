<?php
return [
    'mailer'	=>	[
                        'class' 	=>	'App\\Lib\\MailProvider',
                        'arguments'	=>	['orlionml@gmail.com', 'username', 'password'],
                        'singleton' =>  true,
                    ],

    'shop'	=>	    [
                        'class'	=>	'App\\Lib\\Shop',
                        'arguments'	=>	['@mailer'],
                    ],
];