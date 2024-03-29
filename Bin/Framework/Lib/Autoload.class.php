<?php


namespace Bin\Framework\Lib;


use Bin\Framework\Lib\Logging\Logger;
use Config\AppConfig;

class Autoload
{
    public static function standardMode ()
    {
        self::unload_loaders();
        self::loader([".class.php"]);
        Logger::Info(__METHOD__,"Selected standard mode");
    }


    public static function dynamicMode ()
    {
        self::unload_loaders();
        self::loader(AppConfig::DYNAMIC_AUTOLOAD_EXTENSIONS);
        Logger::Info(__METHOD__,"Selected dynamic mode");
    }


    public static function safeMode ()
    {
        self::unload_loaders();
        self::independentLoader();
    }


    private static function loader ($extensions)
    {
        spl_autoload_register(function ($className) use ($extensions) {

            $path = explode('\\' , $className);
            $pathName = str_replace('\\',DIRECTORY_SEPARATOR, $className);
            $length = count($path);

            if (in_array($path[$length - 1], AppConfig::AUTOLOAD_BLACKLIST))
            {
                Logger::Warn(__CLASS__,"Class '{$className}' is blacklisted from autoload");
                //die("Class '{$className}' is blacklisted from autoload");
                return false;
            }

            if (count($extensions) > 1)
            {
                foreach ($extensions as $extension)
                {
                    $finPath = PROJECT_DIR.DIRECTORY_SEPARATOR.$pathName.$extension;
                    if (file_exists($finPath))
                        break;
                }
            }
            else
                $finPath = PROJECT_DIR.DIRECTORY_SEPARATOR.$pathName.$extensions[0];

            require_once $finPath;

            if (method_exists($className,'__constructStatic'))
                $className::__constructStatic();
            Logger::Info(__CLASS__,"Class '{$className}' Loaded");

            return true;
        });
    }


    private static function independentLoader ()
    {
        spl_autoload_register(function ($className){

            $pathName = str_replace('\\',DIRECTORY_SEPARATOR, $className);

            $finPath = PROJECT_DIR.DIRECTORY_SEPARATOR.$pathName.".class.php";

            require_once $finPath;

        });
    }


    private static function unload_loaders ()
    {
        $functions = spl_autoload_functions();
        if ($functions)
        foreach($functions as $function) {
            spl_autoload_unregister($function);
        }
    }
}