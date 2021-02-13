<?php


namespace App\Models;



class Role extends BaseModel
{
    public static $table_name       = 'roles';

    public static $id_name          = 'id';
    public static $name_name        = 'name';
    public static $level_name       = 'power';

    public static $fillable_fields;


    public static function Put($arr)
    {
        self::$fillable_fields = [
            self::$name_name,
            self::$level_name
        ];
        return parent::Put($arr);
    }


    public static function UpdateByID($id, $arr)
    {
        self::$fillable_fields = [
            self::$name_name,
            self::$level_name
        ];
        return parent::UpdateByID($id, $arr);
    }
}