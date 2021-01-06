<?php


namespace App\Lib\Logging;


use App\Lib\File\Directory;
use App\Lib\File\File;
use App\Lib\Time\Time;
use Config\AppConfig;

class Logger
{
    public static $logfile;
    private static $no_more_log = false;


    private static function PutLog($str = "")
    {
        self::$logfile->Put("$str \n");
    }

    private static function Log_gate($type, $classname, $message, $important)
    {
        self::Log($type, $classname, $message, $important);
    }


    public static function Initialize($filename = 'main')
    {
        $today      = Time::Current("d-m-Y");
        $logname    = $today.'_'.$filename.'.log';
        $filepath   = AppConfig::LOGS_DIR.$logname;

        new Directory(AppConfig::LOGS_DIR);
        self::$logfile = new File($filepath);

        self::PutLog();
        self::PutLog("<--------------------BEGIN-------------------->");

        return self::$logfile;
    }


    public static function Log($status, $classname, $message, $important = false)
    {
        if (!$important && self::$no_more_log === true) return;

        if (!self::$logfile) die("No logger has been initialized");

        $time = Time::Current('H:i:s');

        self::PutLog("[$time] [$status] [$classname]: $message");
    }


    public static function Info($classname, $message, $important = false)
    {
        self::Log_gate('INFO', $classname, $message, $important);
    }


    public static function Warn($classname, $message, $important = false)
    {
        self::Log_gate('WARN', $classname, $message, $important);
    }


    public static function Error($classname, $message, $important = false)
    {
        self::Log_gate('ERROR', $classname, $message, $important);
    }


    public static function Mute()
    {
        self::$no_more_log = true;
    }


    public static function UnMute()
    {
        self::$no_more_log = false;
    }
}