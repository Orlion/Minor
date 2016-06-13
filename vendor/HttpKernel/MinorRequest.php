<?php
/**
 * MinorRequest
 */
namespace Minor\HttpKernel;

use Minor\Config\Config;

class MinorRequest
{
    private static $_instance = null;

    private $url;

    private $requestUrl;

    private $baseUrl;

    private $method = 'get';

    private $getParams = [];

    private $postParams = [];

    private $minorCookie = null;

    private $minorSession = null;

    private $ip;

    private $os;

    private $browser;

    private $server = [];

    private function __construct($url = null, $requestUrl = null, $baseUrl = null, $method = 'get', Array $getParams = [], Array $postParams = [], MinorCookie $minorCookie = null, MinorSession $minorSession = null, $ip = null, $os = null, $browser = null, Array $server = [])
    {
        $this->url          = $url;
        $this->requestUrl   = $requestUrl;
        $this->baseUrl      = $baseUrl;
        $this->method       = $method;
        $this->getParams    = $getParams;
        $this->postParams   = $postParams;
        $this->minorCookie  = $minorCookie;
        $this->minorSession = $minorSession;
        $this->ip           = $ip;
        $this->os           = $os;
        $this->browser      = $browser;
        $this->server       = $server;
    }

    private function __clone(){}

    public static function getInstance($url = null, $requestUrl = null, $baseUrl = null, $method = 'get', Array $getParams = [], Array $postParams = [], MinorCookie $minorCookie = null, MinorSession $minorSession = null, $ip = null, $os = null, $browser = null, Array $server = [])
    {
        if (is_null(self::$_instance) || !self::$_instance instanceof self) {
            self::$_instance = new self($url, $requestUrl, $baseUrl, $method, $getParams, $postParams, $minorCookie, $minorSession, $ip, $os, $browser, $server);
        }

        return self::$_instance;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getRequestUrl()
    {
        return $this->requestUrl;
    }

    public function setRequestUrl($requestUrl)
    {
        $this->requestUrl = $requestUrl;
    }

    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function setMethod($method)
    {
        $this->method = $method;
    }

    public function setGetParams(Array $getParams)
    {
        $this->getParams = $getParams;
    }

    public function setPostParams(Array $postParams)
    {
        $this->postParams = $postParams;
    }

    public function getParams()
    {
        return array_merge($this->getParams, $this->postParams);
    }

    public function setParams(Array $getParams, Array $postParams)
    {
        $this->getParams  = $getParams;
        $this->postParams = $postParams;
    }

    public function getMinorCookie()
    {
        return $this->minorCookie;
    }

    public function setMinorCookie(MinorCookie $minorCookie)
    {
        $this->minorCookie = $minorCookie;
    }

    public function getMinorSession()
    {
        return $this->minorSession;
    }

    public function setMinorSession(MinorSession $minorSession)
    {
        $this->minorSession = $minorSession;
    }

    public function getIp()
    {
        if (empty($this->ip)) {
            if (array_key_exists('HTTP_X_FORWARDED_FOR',$_SERVER) && $_SERVER["HTTP_X_FORWARDED_FOR"]) {
                $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } elseif (array_key_exists('HTTP_CLIENT_IP',$_SERVER) && $_SERVER["HTTP_CLIENT_IP"]) {
                $ip = $_SERVER["HTTP_CLIENT_IP"];
            } elseif ($_SERVER["REMOTE_ADDR"]) {
                $ip = $_SERVER["REMOTE_ADDR"];
            } elseif (getenv("HTTP_X_FORWARDED_FOR")) {
                $ip = getenv("HTTP_X_FORWARDED_FOR");
            } elseif (getenv("HTTP_CLIENT_IP")) {
                $ip = getenv("HTTP_CLIENT_IP");
            } elseif (getenv("REMOTE_ADDR")) {
                $ip = getenv("REMOTE_ADDR");
            } else {
                $ip = "Unknown";
            }
            if ( strpos($ip,',') && $iparr = explode(',',$ip) ) {
                $ip = $iparr[0];
            }

            $this->ip = $ip;
        }

        return $this->ip;
    }

    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    public function getOs()
    {
        if (empty($this->os)) {
            $agent = $_SERVER['HTTP_USER_AGENT'];

            if (preg_match('/win/i', $agent) && strpos($agent, '95'))
            {
                $os = 'Windows 95';
            }
            else if (preg_match('/win 9x/i', $agent) && strpos($agent, '4.90'))
            {
                $os = 'Windows ME';
            }
            else if (preg_match('/win/i', $agent) && preg_match('/98/i', $agent))
            {
                $os = 'Windows 98';
            }
            else if (preg_match('/win/i', $agent) && preg_match('/nt 6.0/i', $agent))
            {
                $os = 'Windows Vista';
            }
            else if (preg_match('/win/i', $agent) && preg_match('/nt 6.1/i', $agent))
            {
                $os = 'Windows 7';
            }
            else if (preg_match('/win/i', $agent) && preg_match('/nt 6.2/i', $agent))
            {
                $os = 'Windows 8';
            }else if(preg_match('/win/i', $agent) && preg_match('/nt 10.0/i', $agent))
            {
                $os = 'Windows 10';#添加win10判断
            }else if (preg_match('/win/i', $agent) && preg_match('/nt 5.1/i', $agent))
            {
                $os = 'Windows XP';
            }
            else if (preg_match('/win/i', $agent) && preg_match('/nt 5/i', $agent))
            {
                $os = 'Windows 2000';
            }
            else if (preg_match('/win/i', $agent) && preg_match('/nt/i', $agent))
            {
                $os = 'Windows NT';
            }
            else if (preg_match('/win/i', $agent) && preg_match('/32/i', $agent))
            {
                $os = 'Windows 32';
            }
            else if (preg_match('/linux/i', $agent))
            {
                $os = 'Linux';
            }
            else if (preg_match('/unix/i', $agent))
            {
                $os = 'Unix';
            }
            else if (preg_match('/sun/i', $agent) && preg_match('/os/i', $agent))
            {
                $os = 'SunOS';
            }
            else if (preg_match('/ibm/i', $agent) && preg_match('/os/i', $agent))
            {
                $os = 'IBM OS/2';
            }
            else if (preg_match('/Mac/i', $agent) && preg_match('/PC/i', $agent))
            {
                $os = 'Macintosh';
            }
            else if (preg_match('/PowerPC/i', $agent))
            {
                $os = 'PowerPC';
            }
            else if (preg_match('/AIX/i', $agent))
            {
                $os = 'AIX';
            }
            else if (preg_match('/HPUX/i', $agent))
            {
                $os = 'HPUX';
            }
            else if (preg_match('/NetBSD/i', $agent))
            {
                $os = 'NetBSD';
            }
            else if (preg_match('/BSD/i', $agent))
            {
                $os = 'BSD';
            }
            else if (preg_match('/OSF1/i', $agent))
            {
                $os = 'OSF1';
            }
            else if (preg_match('/IRIX/i', $agent))
            {
                $os = 'IRIX';
            }
            else if (preg_match('/FreeBSD/i', $agent))
            {
                $os = 'FreeBSD';
            }
            else if (preg_match('/teleport/i', $agent))
            {
                $os = 'teleport';
            }
            else if (preg_match('/flashget/i', $agent))
            {
                $os = 'flashget';
            }
            else if (preg_match('/webzip/i', $agent))
            {
                $os = 'webzip';
            } else if (preg_match('/offline/i', $agent)) {
                $os = 'offline';
            } else {
                $os = '未知操作系统';
            }

            $this->os = $os;
        }

        return $this->os;
    }

    public function setOs($os)
    {
        $this->os = $os;
    }

    public function getBrowser()
    {
        if (empty($this->browser)) {
            $sys = $_SERVER['HTTP_USER_AGENT'];  //获取用户代理字符串
            if (stripos($sys, "Firefox/") > 0) {
                preg_match("/Firefox\/([^;)]+)+/i", $sys, $b);
                $exp[0] = "Firefox";
                $exp[1] = $b[1];  //获取火狐浏览器的版本号
            } elseif (stripos($sys, "Maxthon") > 0) {
                preg_match("/Maxthon\/([\d\.]+)/", $sys, $aoyou);
                $exp[0] = "傲游";
                $exp[1] = $aoyou[1];
            } elseif (stripos($sys, "MSIE") > 0) {
                preg_match("/MSIE\s+([^;)]+)+/i", $sys, $ie);
                $exp[0] = "IE";
                $exp[1] = $ie[1];  //获取IE的版本号
            } elseif (stripos($sys, "OPR") > 0) {
                preg_match("/OPR\/([\d\.]+)/", $sys, $opera);
                $exp[0] = "Opera";
                $exp[1] = $opera[1];
            } elseif(stripos($sys, "Edge") > 0) {
                //win10 Edge浏览器 添加了chrome内核标记 在判断Chrome之前匹配
                preg_match("/Edge\/([\d\.]+)/", $sys, $Edge);
                $exp[0] = "Edge";
                $exp[1] = $Edge[1];
            } elseif (stripos($sys, "Chrome") > 0) {
                preg_match("/Chrome\/([\d\.]+)/", $sys, $google);
                $exp[0] = "Chrome";
                $exp[1] = $google[1];  //获取google chrome的版本号
            } elseif(stripos($sys,'rv:')>0 && stripos($sys,'Gecko')>0){
                preg_match("/rv:([\d\.]+)/", $sys, $IE);
                $exp[0] = "IE";
                $exp[1] = $IE[1];
            } else {
                $exp[0] = "未知浏览器";
                $exp[1] = "";
            }

            $this->browser = $exp[0].'('.$exp[1].')';
        }

        return $this->browser;
    }

    public function setBrowser($browser)
    {
        $this->browser = $browser;
    }

    public function getServer()
    {
        return $this->server;
    }

    public function setServer(Array $server)
    {
        $this->server = $server;
    }

    public function get($key , $default = '')
    {
        if (isset($this->getParams[$key])) {
            $defaultFilter = Config::get(['app' => 'DEFAULT_FILTER']);
            if ($defaultFilter) {
                if (is_string($defaultFilter)) {
                    if (!function_exists($defaultFilter))
                        throw new ConfigException('配置文件[app.php]:配置项[DEFAULT_FILTER]函数[' . $defaultFilter . ']不存在');
                    
                    return $defaultFilter($this->getParams[$key]);
                }

                if (!($defaultFilter instanceof \Closure))
                    throw new ConfigException('配置文件[app.php]:配置项[DEFAULT_FILTER]必须为字符串或匿名函数');

                return $defaultFilter($this->getParams[$key]);
            }

            return $this->getParams[$key];
        }

        return $default;
    }

    public function setGetParameter($key , $value)
    {
        $this->getParams[$key] = $value;
    }

    public function post($key , $default = '')
    {
        if (isset($this->postParams[$key])) {
            $defaultFilter = Config::get(['app' => 'DEFAULT_FILTER']);
            if ($defaultFilter) {
                if (is_string($defaultFilter)) {
                    if (!function_exists($defaultFilter))
                        throw new ConfigException('配置文件[app.php]:配置项[DEFAULT_FILTER]函数[' . $defaultFilter . ']不存在');

                    return $defaultFilter($this->postParams[$key]);
                }

                if (!($defaultFilter instanceof \Closure))
                    throw new ConfigException('配置文件[app.php]:配置项[DEFAULT_FILTER]必须为字符串或匿名函数');

                return $defaultFilter($this->postParams[$key]);
            }

            return $this->postParams[$key];
        }

        return $default;
    }

    public function setPostParameter($key, $value)
    {
        $this->postParams[$key] = $value;
    }
}