<?php

namespace Minor\HttpKernel;

class MinorCookie
{
    private static $_instance;

    private function __construct(){}

    private function __clone(){}

    public static function getInstance()
    {
        if (is_null(self::$_instance) || !self::$_instance instanceof self) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function getCookies()
    {
        return $_COOKIE;
    }

    public function getCookie($key , $default = '')
    {
        return isset($_COOKIE[$key]) ? $_COOKIE[$key] : $default;
    }

    public function setCookie($name , $value , $expire = 0 , $path = '' , $domain = '' , $secure = false , $httpOnly = false)
    {
        setcookie($name , $value , $expire , $path , $domain , $secure, $httpOnly);
    }

    public function delCookie($name)
    {
        return setcookie($name) || setcookie($name , '' , now()-1);
    }
}