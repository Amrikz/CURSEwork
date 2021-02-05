<?php


namespace App\Models;


interface ModelInterface
{
    public static function Select($what, $where, $params);

    public static function Insert($where, $params);

    public static function Update($what, $where, $params);

    public static function Delete($where, $params);
}