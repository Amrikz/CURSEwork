<?php


namespace Bin\Framework\Lib\Route;


use Config\AppConfig;

class Url
{
    public $url = '';
    public $url_trace_route = -1;

    private $_destination_url;


    public function __construct($url = null)
    {
        if ($url == null) $this->url = mb_strtolower($_GET['url']);
        else $this->url = mb_strtolower($url);
    }


    private function argCheck($segment)
    {
        if ($segment == AppConfig::URL_ARG_CHAR)
        {
            if (self::getSegment($this->url_trace_route) != NULL) return true;
            else return false;
        }
        elseif ($segment == AppConfig::URL_VARY_ARG_CHAR) return true;
        else return false;
    }


    public function setDestination($destination_url)
    {
        $this->_destination_url = mb_strtolower($destination_url);
    }


    public function getSegment($num)
    {
        $res = explode('/', $this->url);
        return $res[$num];
    }


    public function getAllSegments()
    {
        $res = explode('/', $this->url);
        return $res;
    }


    public function compareUrl($url = null)
    {
        if ($url == null) $url = $this->_destination_url;

        $this->url_trace_route++;
        $res = explode('/', $url);
        if($res[$this->url_trace_route] == self::getSegment($this->url_trace_route) || $this->argCheck($res[$this->url_trace_route]))
        {   
            if(self::getSegment($this->url_trace_route) == NULL || self::compareUrl($url))
            {
                $this->url_trace_route = -1;
                return true;
            }
            return false;
        }
        return false;
    }


    public function getArgs($url = null)
    {
        if ($url == null) $url = $this->_destination_url;

        $res = explode('/', $url);
        $fin_arr = [];

        foreach ($res as $key => $value)
        {
            $this->url_trace_route++;
            if ($value == AppConfig::URL_ARG_CHAR ||
            $value == AppConfig::URL_VARY_ARG_CHAR) $fin_arr[] = self::getSegment($this->url_trace_route);
        }

        $this->url_trace_route = -1;
        return $fin_arr;
    }


    public static function getUrlAddition($add_slash = true) {
        $res = str_replace($_GET['url'],'', $_SERVER['REDIRECT_URL']);
        if (!$res && $add_slash) $res = '/';
        return $res;
    }


    public static function addPrefixToHref(&$arr, $needle = 'href=')
    {
        $addition = rtrim(self::getUrlAddition(),'/');
        if ($addition)
            foreach ($arr as $key=>$value)
            {
                $arr[$key] = substr_replace($value, $addition, strpos($value, $needle) + strlen($needle) + 1, 0);
            }
    }
}