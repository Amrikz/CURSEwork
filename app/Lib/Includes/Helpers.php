<?php


use App\Lib\Errors\ErrProcessor;


function strError($errno)
{
    return ErrProcessor::StrError($errno);
}


function makeError($text, $error = null)
{
    ErrProcessor::MakeError($text, $error);
}


function arrayToStr($arr, $delimiter = ',', $recursive = false)
{
    $res = null;
    foreach ($arr as $key=>$value)
    {
        if (is_array($value) && $recursive == true) $value = arrayToStr($value, $delimiter, true);
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


function arrayDataToStr($arr, $delimiter = ',', $recursive = false)
{
    $res = null;
    foreach ($arr as $key=>$value)
    {
        if (is_array($value) && $recursive == true) $value = arrayDataToStr($value, $delimiter, true);
        if (is_null($value)) $value = 'null';
        if (is_bool($value) === true) $value = $value ? 'true' : 'false';
        $res .= "$value"."$delimiter";
    }
    return trim($res, $delimiter);
}


function forEachEcho($arr)
{
    if (!$arr) return false;

    foreach ($arr as $key=>$value)
    {
        echo $value;
    }

    return true;
}