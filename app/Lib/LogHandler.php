<?php

namespace App\Lib;

use Minor\Proxy\InvocationHandler;

class LogHandler implements InvocationHandler
{
    public function invoke($target, \ReflectionMethod $method, Array $args = [])
    {
        $this->before();
        $result = $method->invokeArgs($target, $args);
        $this->after();

        return $result;
    }

    public function before()
    {
        echo '[LogHandler] before<br/><br/>';
    }

    public function after()
    {
        echo '[LogHandler] after<br/><br/>';
    }
}