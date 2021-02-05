<?php


namespace App\Lib\Errors;


class ErrProcessor
{
    public static function StrError($errno)
    {
        return array_flip(array_slice(get_defined_constants(true)['Core'], 0, 16, true))[$errno];
    }


    public static function MakeError($text, $error = null)
    {
        if (is_null($error)) $error = E_USER_ERROR;
        trigger_error($text, $error);
    }
}