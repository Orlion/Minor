<?php

namespace Minor\Proxy;

interface InvocationHandler
{
    public function invoke($target, \ReflectionMethod $method, Array $args = []);

    public function before();

    public function after();
}