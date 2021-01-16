<?php


namespace App\Models;


use App\Lib\Middleware\Repository;

abstract class AbstractModel implements ModelInterface
{
    public static function Select($what, $table, $where = null, $params = null)
    {
        return Repository::Select($what, $table, $where, $params);
    }

    public static function Insert($what, $table, $params = null)
    {
        return Repository::Insert($what, $table, $params);
    }

    public static function Update($what, $table, $where = null, $params = null)
    {
        return Repository::Update($what, $table, $where, $params);

    }

    public static function Delete($table, $where, $params = null)
    {
        return Repository::Delete($table, $where, $params);
    }
}