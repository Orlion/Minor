<?php

namespace Minor\Proxy;

class TargetProxy
{
    private $target;

    private $invocationHandler;

    public function __construct($target, InvocationHandler $invocationHandler)
    {
        $this->target = $target;
        $this->invocationHandler = $invocationHandler;
    }

    public function __call($name, $arguments)
    {
        try {
            $reflectionClass = new \ReflectionClass($this->target);

            if (!$reflectionClass->hasMethod($name))
                throw new ProxyException('类[' . $reflectionClass->getName()  . ']:未定义' . '[' . $name . ']方法');

            $method = $reflectionClass->getMethod($name);

            if (!$method->isPublic())
                throw new ProxyException('类[' . $reflectionClass->getName  . ']:方法[' . $name . ']不是公开方法');

            return $this->invocationHandler->invoke($this->target, $method, $arguments);
        } catch (\ReflectionException $re) {
            throw new ProxyException('类[' . $reflectionClass->getName  . ']:获取代理类失败');
        }
    }
}