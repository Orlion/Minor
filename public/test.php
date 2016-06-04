<?php


$arr = [
    'my_error' => function($errno, $errstr)
                {
                    echo 'errno=' . $errno;
                },
];

set_error_handler($arr['my_error']);

echo $a;