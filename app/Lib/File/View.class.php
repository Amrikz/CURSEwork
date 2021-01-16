<?php


namespace App\Lib\File;


use App\Lib\Logging\Logger;
use Config\AppConfig;

class View
{
    public static $RequireAboveInclude = true;


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
        self::GetFile(PROJECT_DIR.AppConfig::VIEW_DIR.$filename);
    }


    private static function GetFile($path)
    {
        $filename = Filename::Relative($path);
        Logger::Info(__METHOD__,"File {$filename} has been view-ed");

        if (self::$RequireAboveInclude) require $path;
        else include $path;
    }
}