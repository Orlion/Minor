<?php

namespace Minor\Proxy;

class Proxy
{
    public static function newProxyInstance($target, InvocationHandler $invocationHandler)
    {
        return new TargetProxy($target, $invocationHandler);
    }
}