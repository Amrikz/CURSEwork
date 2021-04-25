<?php


namespace Bin\Framework\Lib\Request;


class Response
{
    public function __construct($arr, $code = 200)
    {
        response($arr, $code);
    }


    private static function _responseBody($response, $response_code)
    {
        if (!headers_sent()) http_response_code($response_code);
        if (isset($response) && $response && $response != 'null')
            echo ($response);
        die;
    }


    public static function Arr($arr, $response_code = 200)
    {
        if ($arr['response_code'])
        {
            $response_code = $arr['response_code'];
            unset($arr['response_code']);
        }
        self::_responseBody(var_export($arr,true),$response_code);
    }


    public static function Json($arr, $response_code = 200)
    {
        header('Content-Type: application/json');
        if ($arr['response_code'])
        {
            $response_code = $arr['response_code'];
            unset($arr['response_code']);
        }
        self::_responseBody(json_encode($arr),$response_code);
    }


    public static function Raw($data, $response_code = 200)
    {
        self::_responseBody($data,$response_code);
    }
}