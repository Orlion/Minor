<?php
/**
 * Minor - A PHP Framework [It just did what a framework should do.]
 *
 * @package  Minor
 * @author   Orlion <orlionml@gmail.com>
 */

/*
|--------------------------------------------------------------------------
| Define The Application
|--------------------------------------------------------------------------
|
| Define some constant for the application.
|
*/
define('APP_DIR', realpath(__DIR__.'/../app/') .DIRECTORY_SEPARATOR);

define('VENDOR_DIR', realpath(__DIR__.'/../vendor/') .DIRECTORY_SEPARATOR);

define('PUBLIC_DIR', realpath(__DIR__) .DIRECTORY_SEPARATOR);

define('ROOT_DIR', realpath(__DIR__.'/../') .DIRECTORY_SEPARATOR);
/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the minor application, we can run.
|
*/
require VENDOR_DIR . 'Minor.php';
\Minor\Minor::run();