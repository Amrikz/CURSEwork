<?php


namespace App\Lib\Request;


use Config\AppConfig;

class Request
{
    public static $request;


    private static function _override($override_post = false)
    {
        if (!$override_post) $override_post = AppConfig::REQUEST_DEFAULT_OVERRIDE_POST;
        if ($override_post && self::$request && !empty(self::$request)) $_POST = self::$request;
    }


    public static function get($override_post = false)
    {
        if (!self::$request)
        {
            $request = json_decode(file_get_contents('php://input'), true);
            self::$request = $request;
        }
        self::_override($override_post);
        return self::$request;
    }
}