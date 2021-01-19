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
}