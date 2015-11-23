<?php

require '../MinorCore/Route/Route.php';
$url = 'test/test/test?p1=1&p2=2#p3=3';

var_dump(\MinorCore\Route\Route::generateUrl($url));
?>