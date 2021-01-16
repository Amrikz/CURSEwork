<?php


namespace App\Models;


interface ModelInterface
{
    public static function Select($what, $table, $where, $params);

    public static function Insert($table, $where, $params);

    public static function Update($what, $table, $where, $params);

    public static function Delete($table, $where, $params);
}