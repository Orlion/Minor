<?php

namespace Minor\View;

class View
{
    public static function render($tpl , Array $params = [])
    {
        require VENDOR_DIR . 'View/functions.php';

        $moduleTplArr = explode(':', $tpl);
        if (empty($moduleTplArr[0]) || empty($moduleTplArr[1]) || empty($moduleTplArr[2]))
            throw new ViewException('模板文件[' . $tpl . ']格式错误,模板文件名必须类似于:XXX:XXX:XXX.xx');

        $viewFilePath = APP_DIR . 'Modules/' . $moduleTplArr[0] . '/Tpl/' . $moduleTplArr[1] . '/' . $moduleTplArr[2];
        if (!file_exists($viewFilePath))
            throw new ViewException('模板文件[' . $tpl . ']不存在');

        extract($params);

        ob_start();

        require $viewFilePath;

        return ob_get_clean();
    }
}