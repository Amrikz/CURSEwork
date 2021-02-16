<?php


namespace App\Models;


use App\Lib\Middleware\Repository;

abstract class BaseModel implements ModelInterface
{
    public static $table_name       = '';

    public static $id_name          = 'id';

    public static $fillable_fields  = [];


    protected static function fillable_init($arr = null, $complete = false)
    {
        if (!self::$fillable_fields || $complete)
            self::$fillable_fields = $arr;
    }


    public static function Select($what, $where = null, $params = null)
    {
        return Repository::Select($what, static::$table_name, $where, $params);
    }

    public static function Insert($what, $params = null)
    {
        return Repository::Insert($what, static::$table_name, $params);
    }

    public static function Update($what, $where = null, $params = null)
    {
        return Repository::Update($what, static::$table_name, $where, $params);
    }

    public static function Delete($where, $params = null)
    {
        return Repository::Delete(static::$table_name, $where, $params);
    }


    public static function FindBy($param, $value, $params = null)
    {
        $param .= "_name";
        $where = [
            static::$$param => $value
        ];

        return self::Select('*', $where, $params);
    }


    public static function GetAll($params = null)
    {
        return self::Select('*', null, $params);
    }


    public static function GetByID($id)
    {
        $where = [
            static::$id_name => $id
        ];

        return self::Select('*', $where)[0];
    }


    public static function Put($arr)
    {
        foreach (static::$fillable_fields as $key=>$field)
        {
            if ($arr[$field]) $what[$field] = $arr[$field];
        }

        return self::Insert($what);
    }


    public static function UpdateByID($id, $arr)
    {
        if (!static::$fillable_fields) static::fillable_init();
        foreach (static::$fillable_fields as $key=>$field)
        {
            if ($arr[$field]) $what[$field] = $arr[$field];
        }

        $where = [
            static::$id_name => $id
        ];

        return self::Update($what, $where);
    }


    public static function DeleteByID($id)
    {
        $where = [
            static::$id_name => $id
        ];

        return self::Delete($where);
    }
}