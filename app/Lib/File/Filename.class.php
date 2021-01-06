<?php


namespace App\Lib\File;


class Filename
{
    public static function Relative($filename)
    {
        $filename = str_replace(PROJECT_DIR,'', $filename);
        return $filename;
    }
}