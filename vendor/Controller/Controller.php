<?php

namespace Minor\Controller;

use Minor\Framework\Context;

class Controller
{
    public function redirect($url)
    {
        ob_end_clean();
        header('location:' . $url);
        exit();
    }

    public function forward($controller, $action, Array $params)
    {
        return Context::getApp()->invoke($controller, $action, $params);
    }

    public function forwardUrl($url)
    {
        $minorRequest = Context::setMinorRequest();
        $minorRequest->setUrl($url);
        return Context::getApp()->handle($minorRequest);
    }
}