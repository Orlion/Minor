<?php

function include_tpl($module, $controller, $tpl)
{
    require_once (!defined('APP_DIR') ? APP_DIR : realpath(__DIR__ . '/../../app/') .DIRECTORY_SEPARATOR) . 'Modules' . '/' . $module . '/Tpl/' . $controller . '/' . $tpl;
}

function url($path)
{
    return Url::gen($path);
}