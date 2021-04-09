<?php


namespace Bin\Framework\Lib\Handlers;


use Bin\Framework\Lib\Logging\Logger;
use Config\AppConfig;

class ExceptionHandler
{


    public static function Set()
    {
        self::Handler();
        Logger::Info(__METHOD__,"Exception handler set!");
    }


    public static function Unset()
    {
        set_exception_handler(null);
        Logger::Info(__METHOD__,"Exception handler unset!");

    }


    private static function Handler()
    {
        set_exception_handler(function ($exception) {
            $message = join(" ", [
                $exception->getMessage(), "in", $exception->getFile(), "line", $exception->getLine(), "code:", $exception->getCode(),
                "\nstack trace:", $exception->getTraceAsString()]);
            Logger::Error(__CLASS__, $message);
            http_response_code(500);
            if (AppConfig::DEBUG_MODE) echo "<b>$message</b>";
            die();
        });
    }
}