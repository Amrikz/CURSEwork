<?php


namespace Bin\Framework\Lib\Format;


use Config\AppConfig;

class SpecialFormatter
{
    public static function Escape($str, $char_arr = null)
    {
        if (!$char_arr) $char_arr = AppConfig::ESCAPED_CHARS;

        foreach ($char_arr as $value)
        {
            $str = str_replace($value, "\\$value", $str);
        }
        return $str;
    }


    public static function FormatStrForDB($str)
    {
        $str = self::Escape($str);
        return $str;
    }
}