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


    public static function RegisterInsert($login, $password)
    {
        $what = [
            self::$login_name       => $login,
            self::$password_name    => $password,
            self::$role_id_name     => 1,
        ];
        return parent::Insert($what);
    }


    public static function UpdateByID($id, $arr)
    {
        self::$fillable_fields = [
            self::$login_name,
            self::$password_name,
            self::$role_id_name
        ];
        return parent::UpdateByID($id, $arr);
    }
}