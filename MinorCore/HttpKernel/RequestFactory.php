<?php

namespace MinorCore\HttpKernel;

class RequestFactory{

	public static function bulidRequest(){

		$request = Request::getRequest();

		$request->setUrl(self::getUrl());

		$request->setBaseUrl(self::getBaseUrl());

		$request->setMethod(self::getMethod());

		$request->setIp(self::getIp());

		$request->setOs(self::getOs());

		$request->setParams(self::getParams());

		$request->setBrowser(self::getBrowser());

		$request->setMinorCookie(self::getMinorCookie());

		return $request;
	}

	public static function getUrl(){

		return $_SERVER['REQUEST_URI'];
	}

	public static function getMethod(){

		return $_SERVER['REQUEST_METHOD'];
	}

	public static function getIp(){

		if (array_key_exists('HTTP_X_FORWARDED_FOR',$_SERVER) && $_SERVER["HTTP_X_FORWARDED_FOR"])
		{
			$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		}
		elseif (array_key_exists('HTTP_CLIENT_IP',$_SERVER) && $_SERVER["HTTP_CLIENT_IP"])
		{
			$ip = $_SERVER["HTTP_CLIENT_IP"];
		}
		elseif ($_SERVER["REMOTE_ADDR"])
		{
			$ip = $_SERVER["REMOTE_ADDR"];
		}
		elseif (getenv("HTTP_X_FORWARDED_FOR"))
		{
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		}
		elseif (getenv("HTTP_CLIENT_IP"))
		{
			$ip = getenv("HTTP_CLIENT_IP");
		}
		elseif (getenv("REMOTE_ADDR"))
		{
			$ip = getenv("REMOTE_ADDR");
		}
		else
		{
			$ip = "Unknown";
		}
		if ( strpos($ip,',') && $iparr = explode(',',$ip) )
		{
			$ip = $iparr[0];
		}
		return $ip;
	}

	public static function getOs(){

		$agent = $_SERVER['HTTP_USER_AGENT'];
	    $os = false;
	 
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
	    }
	    else if (preg_match('/offline/i', $agent))
	    {
	      $os = 'offline';
	    }
	    else
	    {
	      $os = '未知操作系统';
	    }
	    return $os;  
	}

	public static function getBrowser(){

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

     	return $exp[0].'('.$exp[1].')';
	}

	public static function getMinorCookie(){

		return MinorCookie::getMinorCookie();
	}

	public static function getParams(){

		return array_merge($_GET , $_POST);
	}
	/**
	 * 获取baseUrl ， eg:/Minor/Public
	 * from symfony2
	 */
	public static function getBaseUrl(){

		$filename = basename($_SERVER['SCRIPT_FILENAME']); // index.php

        if (basename($_SERVER['SCRIPT_NAME']) === $filename) {
            $baseUrl = $_SERVER['SCRIPT_NAME'];
        } elseif (basename($_SERVER['PHP_SELF']) === $filename) {
            $baseUrl = $_SERVER['PHP_SELF'];
        } elseif (basename($_SERVER['ORIG_SCRIPT_NAME']) === $filename) {
            $baseUrl = $_SERVER['ORIG_SCRIPT_NAME']; // 1and1 shared hosting compatibility
        } else {

            $path = isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : '';
            $file = isset($_SERVER['SCRIPT_FILENAME']) ? $_SERVER['SCRIPT_FILENAME'] : '';
            $segs = explode('/', trim($file, '/'));
            $segs = array_reverse($segs);
            $index = 0;
            $last = count($segs);
            $baseUrl = '';
            do {
                $seg = $segs[$index];
                $baseUrl = '/'.$seg.$baseUrl;
                ++$index;
            } while ($last > $index && (false !== $pos = strpos($path, $baseUrl)) && 0 != $pos);
        }

        $requestUri = self::getUrl();

        if ($baseUrl && false !== $prefix = self::getUrlencodedPrefix($requestUri, $baseUrl)) {

            return $prefix;
        }

        if ($baseUrl && false !== $prefix = self::getUrlencodedPrefix($requestUri, rtrim(dirname($baseUrl), '/'.DIRECTORY_SEPARATOR).'/')) {

            return rtrim($prefix, '/'.DIRECTORY_SEPARATOR);
        }

        $truncatedRequestUri = $requestUri;
        if (false !== $pos = strpos($requestUri, '?')) {
            $truncatedRequestUri = substr($requestUri, 0, $pos);
        }

        $basename = basename($baseUrl);

        if (empty($basename) || !strpos(rawurldecode($truncatedRequestUri), $basename)) {

            return '';
        }

        if (strlen($requestUri) >= strlen($baseUrl) && (false !== $pos = strpos($requestUri, $baseUrl)) && $pos !== 0) {
            $baseUrl = substr($requestUri, 0, $pos + strlen($baseUrl));
        }

        return rtrim($baseUrl, '/'.DIRECTORY_SEPARATOR);
	}
	/**
	 * from symfony2
	 */
	private static function getUrlencodedPrefix($string, $prefix){

        if (0 !== strpos(rawurldecode($string), $prefix)) {
            return false;
        }

        $len = strlen($prefix);

        if (preg_match(sprintf('#^(%%[[:xdigit:]]{2}|.){%d}#', $len), $string, $match)) {
            return $match[0];
        }

        return false;
    }
}
?>