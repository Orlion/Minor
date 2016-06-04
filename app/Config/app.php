<?php
/**
 * Application Config
 */
return [
    // 应用名
    'APP_NAME'		=>	'Minor',
    // 编码
    'APP_CHARSET'	=>	'UTF-8',
    // 时区
    'APP_TIMEZONE'	=>	'PRC',

    // 是否自动开启session
    'SESSION_START' => TRUE,
    // 系统异常页面
    'EXCEPTION_PAGE'=>	'exception.html',
    // 系统错误页面
    'ERROR_PAGE'    =>  'error.html',
    // 请求错误页面
    '404_PAGE'  	=>	'404.html',

    // 是否DEBUG
    'DEBUG'         =>  true,

    // 默认变量过滤器
    'DEFAULT_FILTER'    =>  function($param){
                                return htmlspecialchars($param);
                            },
    // 默认错误处理器
    'DEFAULT_ERROR'     =>  function($errno, $errstr, $errfile=null, $errline=null, Array $errcontext){
                                echo 'ERRNO: [' . $errno . '] ,ERRSTR: [' . $errstr . '] <br/>';
                            },
    // 默认异常处理器
    'DEFAULT_EXCEPTION' =>  function($e){
                                throw $e;
                            },
];
