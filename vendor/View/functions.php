<?php

function include_tpl($module, $controller, $tplName)
{
    require APP_DIR . 'Modules' . '/' . $module . '/Tpl/' . $controller . '/' . $tplName;
}

function include_component($controller, $method, Array $params = [])
{
    $app = \Minor\Framework\Context::getApp();
    echo $app->invoke($controller, $method, $params);
}
