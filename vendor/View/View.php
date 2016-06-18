<?php

namespace Minor\View;

class View
{
    public static function render($tpl , Array $params = [])
    {
        $moduleTplArr = explode(':', $tpl);
        if (empty($moduleTplArr[0]) || empty($moduleTplArr[1]) || empty($moduleTplArr[2]))
            throw new ViewException('模板文件[' . $tpl . ']格式错误,模板文件名必须类似于:XXX:XXX:XXX.xx');

        $viewFilePath = (!defined('APP_DIR') ? APP_DIR : realpath(__DIR__ . '/../../app/') .DIRECTORY_SEPARATOR) . 'Modules/' . $moduleTplArr[0] . '/Tpl/' . $moduleTplArr[1] . '/' . $moduleTplArr[2];

        if (!file_exists($viewFilePath))
            throw new ViewException('模板文件[' . $tpl . ']不存在');

        ob_start();

        $functionsFilePath = (!defined('APP_DIR') ? APP_DIR : realpath(__DIR__ . '/../../app/') .DIRECTORY_SEPARATOR) . 'Resource/functions.php';
        is_file($functionsFilePath) && require_once $functionsFilePath;
        extract($params);
        require $viewFilePath;

        return ob_get_clean();
    }
}