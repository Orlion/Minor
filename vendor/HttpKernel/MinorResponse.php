<?php

namespace Minor\HttpKernel;

class MinorResponse
{
    private static $_instance = null;
    
    private $content = '';
    
    private function __construct(){}
    
    private function __clone(){}
    
    public static function getInstance()
    {
        if (is_null(self::$_instance) || !self::$_instance instanceof self) {
            self::$_instance = new self();
        }
        
        return self::$_instance;
    }

    public function send()
    {
        echo is_string($this->content) ? $this->content : '';
    }
    
    public function setHeader($header)
    {
        header((string)$header);
    }
    
    public function setContent($content)
    {
        $this->content = $content;
    }
    
    public function beforeContent($content)
    {
        return is_string($this->content) && is_string($content) ? $this->content = $content . $this->content : false;
    }
    
    public function appendContent($content)
    {
        return is_string($this->content) && is_string($content) ? $this->content .= $content : false;
    }
    
    public function getContent()
    {
        return $this->content;
    }
    
    public function __toString()
    {
        return is_string($this->content) ? $this->content : '';
    }
}

