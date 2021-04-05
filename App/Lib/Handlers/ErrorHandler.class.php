<?php


namespace App\Lib\Handlers;


use App\Lib\Logging\Logger;
use Config\AppConfig;

class ErrorHandler
{


    public static function Set()
    {
        self::Handler();
        Logger::Info(__METHOD__,"Error handler set!");
    }


    public static function Unset()
    {
        set_error_handler(null);
        Logger::Info(__METHOD__,"Error handler unset!");

    }


    private static function Handler()
    {
        set_error_handler(function ($errno, $errstr, $errfile, $errline) {
            if (!(error_reporting() & $errno)) {
                // Этот код ошибки не включён в error_reporting,
                // так что пусть обрабатывается стандартным обработчиком ошибок PHP
                return false;
            }

            switch ($errno){
                case E_ERROR:
                case E_USER_ERROR:
                    $message = self::Log_string($errno, $errstr, $errfile, $errline);
                    Logger::Error(__CLASS__, $message);
                    http_response_code(500);
                    if (AppConfig::DEBUG_MODE) echo "<b>$message</b>";
                    die();
                default:
                    Logger::Warn(__CLASS__, self::Log_string($errno, $errstr, $errfile, $errline));
                    break;
            }
            return true;
        });
    }


    private static function Log_string($errno, $errstr, $errfile, $errline)
    {
        return join(" ", [strerror($errno).':', "'$errstr'", 'in', $errfile, $errline]);
    }
}