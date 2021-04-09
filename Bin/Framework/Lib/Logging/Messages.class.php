<?php


namespace Bin\Framework\Lib\Logging;


class Messages
{
    private static $messages;


    public static function Get($key)
    {
        if ($key) return self::$messages[$key];
        return self::$messages;
    }


    public static function GetAsStatus()
    {
        $res = null;
        if (self::$messages)
            foreach (self::$messages as $key=>$value)
            {
                foreach ($value as $message)
                {
                    if ($key == "statuses") $res[] = $message;
                    elseif ($key == "messages") $res[] = Status::NewResponse($message)->status;
                    else $res[] = Status::NewError($message)->status;
                }
            }
        return $res;
    }


    public static function Status($status)
    {
        self::$messages['statuses'][] = $status;
    }


    public static function Error($message)
    {
        if (is_array($message)) $message = arrayDataToStr($message);
        self::$messages['errors'][] = $message;
        Logger::Error(__METHOD__, $message);
    }


    public static function Message($message)
    {
        if (is_array($message)) $message = arrayDataToStr($message);
        self::$messages['messages'][] = $message;
        Logger::Info(__METHOD__, $message);
    }
}