<?php


function strError($errno)
{
    return array_flip(array_slice(get_defined_constants(true)['Core'], 0, 16, true))[$errno];
}


function makeError($text, $error = null)
{
    if (is_null($error)) $error = E_USER_ERROR;
    trigger_error($text, $error);
}


function arrayToStr($arr, $delimiter = ',')
{
    $res = null;
    foreach ($arr as $key=>$value)
    {
        if (is_null($value)) $value = 'null';
        if (is_bool($value) === true) $value = $value ? 'true' : 'false';
        $res .= "$key = $value"."$delimiter";
    }
    return trim($res, $delimiter);
}


function arrayKeysToStr($arr, $delimiter = ',')
{
    $res = null;
    foreach ($arr as $key=>$value)
    {
        $res .= "$key"."$delimiter";
    }
    return trim($res, $delimiter);
}


function arrayDataToStr($arr, $delimiter = ',')
{
    $res = null;
    foreach ($arr as $key=>$value)
    {
        if (is_null($value)) $value = 'null';
        if (is_bool($value) === true) $value = $value ? 'true' : 'false';
        $res .= "$value"."$delimiter";
    }
    return trim($res, $delimiter);
}