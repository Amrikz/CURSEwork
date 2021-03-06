<?php


namespace App\Lib\Request;


class Request
{
    public static $request;

    public static function get($override_post = false)
    {
        if (!self::$request)
        {
            $request = json_decode(file_get_contents('php://input'), true);
            self::$request = $request;
        }
        if ($override_post && self::$request && !empty(self::$request)) $_POST = self::$request;
        return self::$request;
    }
}