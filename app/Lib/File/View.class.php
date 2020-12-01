<?php


namespace App\Lib\File;


use App\Lib\Config;

class View
{
    public static $RequireAboveInclude = true;

    private static function GetFile($path)
    {
        if (self::$RequireAboveInclude)
        {
            require $path;
        }
        else
        {
            include $path;
        }
    }

    public static function AbsDir($path)
    {
        self::GetFile($path);
    }

    public static function RelDir($path)
    {
        self::GetFile(PROJECT_DIR.$path);
    }

    public static function ViewDir($filename)
    {
        self::GetFile(PROJECT_DIR.Config::VIEW_DIR.$filename);
    }
}