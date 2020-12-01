<?php


namespace App\Lib;


class Autoload
{
    private static function loader ($extensions)
    {
        spl_autoload_register(function ($className) use ($extensions) {

            $path = explode('\\' , $className);
            $className = str_replace('\\',DIRECTORY_SEPARATOR, $className);
            $length = count($path);

            if (in_array($path[$length - 1], Config::AUTOLOAD_BLACKLIST))
            {
                echo "Class '{$className}' is blacklisted from autoload";
                die;
            }

            if (count($extensions) > 1)
            {
                foreach ($extensions as $extension)
                {
                    $finPath = PROJECT_DIR.DIRECTORY_SEPARATOR.$className.$extension;

                    if (file_exists($finPath))
                    {
                        require_once $finPath;
                        return;
                    }
                }
            }

            $finPath = PROJECT_DIR.DIRECTORY_SEPARATOR.$className.$extensions[0];

            require_once $finPath;
        });
    }

    public static function standardMode ()
    {
        self::loader([".class.php"]);
    }


    public static function dynamicMode ()
    {
        self::loader(Config::DYNAMIC_AUTOLOAD_EXTENSIONS);
    }


}