<?php


namespace App\Lib\Request;


class Response
{
    private static function _responseBody($response, $response_code)
    {
        if (!headers_sent()) http_response_code($response_code);
        if (!isset($response) && $response)
            echo ($response);
        die;
    }


    public static function Arr($arr, $response_code = 200)
    {
        self::_responseBody(var_export($arr,true),$response_code);
    }


    public static function Json($arr, $response_code = 200)
    {
        self::_responseBody(json_encode($arr),$response_code);
    }
}