<?php

return [
    // 应用名
    'APP_NAME'	=>	'Minor',
    // 编码
    'CHARSET'	=>	'UTF-8',
    // 时区
    'TIMEZONE'	=>	'PRC',

    // 是否自动开启session
    'SESSION_START' => TRUE,

    'DEBUG'         =>  true,

    'EXCEPTION_HANDLER' =>  function($e){
                                header('HTTP/1.1 500 Internal Server Error');
                                exit(require APP_DIR . 'Resource/exception.php');
                            },
    'ERROR_HANDLER' =>  function($errno, $errstr, $errfile, $errline){
                            header('HTTP/1.1 500 Internal Server Error');
                            exit(require APP_DIR . 'Resource/error.php');
                        },
    '404_HANDLER'   =>  function($url){
                            header('HTTP/1.1 404 Not Found');
                            header("status: 404 Not Found");
                            exit(require APP_DIR . 'Resource/404.php');
                        },


    // 默认变量过滤器
    'DEFAULT_FILTER'    =>  function($param){
                                return htmlspecialchars($param);
                            },

];
