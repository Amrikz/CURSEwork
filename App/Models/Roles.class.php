<?php


namespace App\Models;


class Roles extends BaseModel
{
    public static $table_name       = 'roles';

    public static $id_name          = 'id';
    public static $name_name        = 'name';
    public static $level_name       = 'power';

    public static $fillable_fields;

    public static $admin_power_level= 2;


    public static function __constructStatic()
    {
        parent::params_init();
        parent::fillable_init([
            self::$name_name,
            self::$level_name,
        ]);
    }
}