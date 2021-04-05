<?php


namespace App\Lib\Time;


class Time
{
    public static function Current($format = 'c')
    {
        $timestamp  = time()+date("Z");
        $time       = date($format,$timestamp);

        return $time;
    }
}