<?php
/**
 * Minor - A PHP Framework [It just did what a framework should do.]
 *
 * @package  Minor
 * @author   Orlion <orlionml@gmail.com>
 */
/*
|--------------------------------------------------------------------------
| Define
|--------------------------------------------------------------------------
|
| Define
|
*/
define('APP_DIR', realpath(__DIR__.'/../app/') .DIRECTORY_SEPARATOR);

define('PUBLIC_DIR', realpath(__DIR__) .DIRECTORY_SEPARATOR);

define('VENDOR_DIR', realpath(__DIR__.'/../vendor/') .DIRECTORY_SEPARATOR);

define('ROOT_DIR', realpath(__DIR__.'/../') .DIRECTORY_SEPARATOR);
/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our application. We just need to utilize it! We'll simply require it
| into the script here so that we don't have to worry about manual
| loading any of our classes later on. It feels nice to relax.
|
*/
$loader = require VENDOR_DIR . 'autoload.php';
/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Run The Application
|
*/
$app = \Minor\Framework\App::getInstance(
    $config     = ['app' => require APP_DIR . 'Config/app.php', 'test' => require APP_DIR . 'Config/test.php'],
    $providers  = require APP_DIR . 'Config/providers.php',
    $routes     = require APP_DIR . 'Config/routes.php',
    $events     = require APP_DIR . 'Config/events.php'
);

$response = $app->handle(
    $request = \Minor\HttpKernel\MinorRequestBuilder::buildMinorRequest()
);

$response->send();
