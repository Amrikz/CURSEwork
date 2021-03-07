<?php


namespace App\Lib\Request;


class Request
{
    public static $request;


    private static function _override()
    {
        if (self::$request && !empty(self::$request)) $_POST = self::$request;
    }


    public static function get($override_post = false)
    {
        if (!self::$request)
        {
            $request = json_decode(file_get_contents('php://input'), true);
            self::$request = $request;
        }
        if ($override_post) self::_override();
        return self::$request;
    }
}