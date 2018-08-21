<?php
namespace Omega\Utils;

class Url
{
	public static function Link($link, $param = null, $id = null)
	{
		if(isset($param)) {
			$queryString = '';
			foreach($param as $key => $value) {
				$queryString .= sprintf('&%s=%s', $key, $value);
			}
		}
		else {
			$queryString = '';
		}
		$queryString = substr($queryString, 1);

		if(isset($id) && isset($param)){
            return sprintf('%s?%s#%s', $link, $queryString, $id);
        }
        if(isset($id) && !isset($param)){
            return sprintf('%s#%s', $link, $id);
        }
        if(!isset($id) && isset($param)){
            return sprintf('%s?%s', $link, $queryString);
        }

		return $link;
	}
	public static function Combine()
	{
		$url = '';
		foreach ( func_get_args() as $t )
		{
			$url .= rtrim(trim($t, '/'), '/') . '/';
		}
		$url = rtrim($url, '/');
		return $url;
	}

	public static function CombAndAbs()
	{
		$url = '';
		foreach ( func_get_args() as $t )
		{
			$url .= rtrim(trim($t, '/'), '/') . '/';
		}
		$url = rtrim($url, '/');
		return self::Absolute($url);
	}

	public static function Action($controller, $action, $param = null)
	{
        $queryString = '';
		if(isset($param)) {
			$queryString = self::ToQueryString($param, true);
		}
		return self::CombAndAbs(url('/'), 'admin', sprintf('%s/%s%s', $controller, $action, $queryString));
	}
	
	public static function Absolute($url)
	{
		$pUrk = parse_url($url);
		$finalUrl = isset($pUrk['path']) ? $pUrk['path'] : '/';
		
		if(array_key_exists('query', $pUrk)){
		
			$finalUrl .= '?'.$pUrk['query'];
		}
		if(isset($pUrk['fragment'])){
		    $finalUrl .= '#'.$pUrk['fragment'];
        }
		
		return $finalUrl;
	}

	public static function ParseDomaine($url)
	{
		$parse = parse_url($url);
		return $parse['host'];
	}
	
	public static function ToQueryString($array, $hasInterogationMark)
    {
        $querystring = '';
        foreach ($array as $key => $value) {
            $querystring .= '&' . $key . '=' . $value;
        }
        $querystring = substr($querystring, 1, strlen($querystring)-1);

        $querystring = ($hasInterogationMark ? '?' : '') . $querystring;

        return $querystring;
    }

    public static function PathUrl($dir = __DIR__){

        $root = "";
        $dir = str_replace('\\', '/', realpath($dir));

        //HTTPS or HTTP
        $root .= !empty($_SERVER['HTTPS']) ? 'https' : 'http';

        //HOST
        $root .= '://' . $_SERVER['HTTP_HOST'];

        //ALIAS
        if(!empty($_SERVER['CONTEXT_PREFIX'])) {
            $root .= $_SERVER['CONTEXT_PREFIX'];
            $root .= substr($dir, strlen($_SERVER[ 'CONTEXT_DOCUMENT_ROOT' ]));
        } else {
            $root .= substr($dir, strlen($_SERVER[ 'DOCUMENT_ROOT' ]));
        }

        $root .= '/';

        return $root;
    }
}