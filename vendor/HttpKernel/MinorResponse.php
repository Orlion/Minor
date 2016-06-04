<?php

namespace Minor\HttpKernel;

class MinorResponse
{
    private static $_instance = null;
    
    private $minorSession;
    
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
    
    public function setMinorSession(MinorSession $minorSession)
    {
        $this->minorSession = $minorSession;
    }
    
    public function getMinorSession()
    {
        return $this->minorSession;
    }
    
    public function setHeader($header)
    {
        header((string)$header);
    }
    
    public function setContent($content)
    {
        $this->content = (string)$content;
    }
    
    public function beforeContent($content)
    {
        $this->content = (string)$content . $this->content;
    }
    
    public function appendContent($content)
    {
        $this->content .= (string)$content;
    }
    
    public function getContent()
    {
        return (string)$this->content;
    }
    
    public function outContent()
    {
        echo $this->getContent();
    }
    
    public function __toString()
    {
        return (string)$this->content;
    }
}