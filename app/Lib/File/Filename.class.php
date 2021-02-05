<?php


namespace App\Lib\File;


class Filename
{
    public static function Absolute($rel_path)
    {
        $path = PROJECT_DIR.$rel_path;
        return $path;
    }


    public static function Relative($path)
    {
        $path = str_replace(PROJECT_DIR,'', $path);
        return $path;
    }


    public static function NameExt($path)
    {
        $path = explode(DIRECTORY_SEPARATOR, $path);
        $key = array_key_last($path);
        return $path[$key];
    }


    public static function Extension($filename)
    {
        $extension = explode('.', $filename);
        $key = array_key_last($extension);
        return $extension[$key];
    }
}