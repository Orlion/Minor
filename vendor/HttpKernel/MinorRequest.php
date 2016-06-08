<?php
/**
 * MinorRequest
 */
namespace Minor\HttpKernel;

class MinorRequest
{
    private static $_instance = null;

    private $url;

    private $requestUrl;

    private $baseUrl;

    private $method;

    private $getParams;

    private $postParams;

    private $minorCookie = null;

    private $minorSession = null;

    private $ip;

    private $os;

    private $browser;

    private $server = [];

    private function __construct($url, $method = 'get', Array $getParams = [], Array $postParams = [], $requestUrl = null, $baseUrl = null, $ip = null, $os = null, $browser = null, Array $server = [], MinorCookie $minorCookie = null, MinorSession $minorSession = null)
    {
        $this->url = $url;
        $this->method = $method;
        $this->getParams = $getParams;
        $this->postParams = $postParams;
        $this->requestUrl = $requestUrl;
        $this->baseUrl = $baseUrl;
        $this->ip = $ip;
        $this->os = $os;
        $this->browser = $browser;
        $this->minorCookie  = $minorCookie;
        $this->minorSession = $minorSession;
        $this->server = $server;
    }

    private function __clone(){}

    public static function getInstance($url, $method = 'get', Array $getParams = [], Array $postParams = [], $requestUrl = null, $baseUrl = null, $ip = null, $os = null, $browser = null, Array $server = [], MinorCookie $minorCookie = null, MinorSession $minorSession = null)
    {
        if (is_null(self::$_instance) || !self::$_instance instanceof self) {
            self::$_instance = new self($url, $method, $getParams, $postParams, $requestUrl, $baseUrl, $ip, $os, $browser, $server, $minorCookie, $minorSession);
        }

        return self::$_instance;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function getServer()
    {
        return $this->server;
    }

    public function getParameter($key , $default = '')
    {
        if (isset($this->params[$key])) {
            $appConfig = Context::getConfig()->getApp();
            if (!empty($appConfig['DEFAULT_FILTER'])) {
                $defaultFilter = $appConfig['DEFAULT_FILTER'];

                if (is_string($defaultFilter)) {
                    if (!function_exists($defaultFilter))
                        throw new ConfigException('配置文件[app.php]:配置项[DEFAULT_FILTER]函数[' . $defaultFilter . ']不存在');
                    
                    return $defaultFilter($this->params[$key]);
                }

                if (!($defaultFilter instanceof \Closure))
                    throw new ConfigException('配置文件[app.php]:配置项[DEFAULT_FILTER]必须为字符串或匿名函数');

                return $defaultFilter($this->params[$key]);
            }

            return $this->params[$key];
        }

        return $default;
    }

    public function getMinorCookie()
    {
        return $this->minorCookie;
    }

    public function getMinorSession()
    {
        return $this->minorSession;
    }

    public function getIp()
    {
        return $this->ip;
    }

    public function getOs()
    {
        return $this->os;
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
            }else {
                $exp[0] = "未知浏览器";
                $exp[1] = "";
            }

            $this->browser = $exp[0].'('.$exp[1].')';
        }

        return $this->browser;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function setMethod($method)
    {
        $this->method = $method;
    }

    public function setParams(Array $params)
    {
        $this->params = $params;
    }

    public function setParameter($key , $value)
    {
        $this->params[$key] = $value;
    }

    public function setMinorCookie(MinorCookie $minorCookie)
    {
        $this->minorCookie = $minorCookie;
    }

    public function setMinorSession(MinorSession $minorSession)
    {
        $this->minorSession = $minorSession;
    }
}