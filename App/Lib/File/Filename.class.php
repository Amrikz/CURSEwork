<?php


namespace App\Lib\File;


class Filename
{
    public static function Absolute($rel_path)
    {
        $path   = PROJECT_DIR.$rel_path;
        return $path;
    }


    public static function Relative($path)
    {
        $path   = str_replace(PROJECT_DIR,'', $path);
        return $path;
    }


    public static function NameExt($path)
    {
        $path   = explode(DIRECTORY_SEPARATOR, $path);
        $key    = array_key_last($path);
        return $path[$key];
    }


    public static function Extension($filename)
    {
        $extension  = explode('.', $filename);
        $key        = array_key_last($extension);
        return $extension[$key];
    }


    public static function PathWithoutName($filename)
    {
        $path   = explode(DIRECTORY_SEPARATOR, $filename);
        $res    = DIRECTORY_SEPARATOR;
        $last   = array_key_last($path);
        foreach ($path as $key=>$value)
        {
            if ($key == $last) break;
            if ($value) $res .= $value.DIRECTORY_SEPARATOR;
        }
        return $res;
    }
}