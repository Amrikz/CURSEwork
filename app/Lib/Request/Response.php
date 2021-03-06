<?php


namespace App\Lib\Request;


class Response
{
    public static function Json($arr)
    {
        if ($arr)
            echo json_encode($arr);
        die;
    }
}