<?php


namespace App\Lib\Random;


class RandomVars
{
    public static function StrFromArr($arr)
    {
        if (!$arr) return null;
        $upper_limit = count($arr) - 1;
        $num = rand(0, $upper_limit);
        return $arr[$num];
    }


    public static function Str($length)
    {
        $multiplier = 1;
        if ($length > 32) $multiplier = ceil($length/32);

        if ($multiplier >= 1)
            for ($i = 0; $i != $multiplier; $i++)
            {
                $hash .= MD5(microtime());
            }

        $res = substr(str_shuffle($hash), 0, $length);
        return $res;
    }
}