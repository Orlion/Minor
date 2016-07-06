<?php

namespace Minor\Controller;

use Minor\HttpKernel\MinorRequest;
use Minor\Route\Url;

class Controller
{
    public $app = null;

    public function __construct(\Minor\Framework\App $app)
    {
        $this->app = $app;
    }

    protected function redirect($url)
    {
        ob_end_clean();
        header('location:' . Url::gen($url));
        exit();
    }

    protected function forward($controller, $action, Array $params)
    {
        return $this->app->invoke($controller, $action, $params);
    }

    protected function forwardUrl($url)
    {
        $minorRequest = MinorRequest::getInstance($url);
        return $this->app->handle($minorRequest);
    }
    
}
