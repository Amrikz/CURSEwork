<?php


namespace App\Models;



class Users extends BaseModel
{
    public static $table_name       = 'users';

    public static $id_name          = 'id';
    public static $login_name       = 'login';
    public static $password_name    = 'password';
    public static $role_id_name     = 'role_id';

    public static $fillable_fields;


    public static function __constructStatic()
    {
        parent::params_init();
        parent::fillable_init([
            self::$login_name,
            self::$password_name,
            self::$role_id_name
        ]);
    }


    public static function RegisterInsert($what)
    {
        $what[self::$role_id_name] = 1;
        return parent::Put($what);
    }
}