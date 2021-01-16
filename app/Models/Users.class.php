<?php


namespace App\Models;


use Config\UserConfig;

class Users extends AbstractModel
{
    public static $table_name       = UserConfig::TABLE_NAME;

    public static $id_name          = UserConfig::ID_NAME;
    public static $login_name       = UserConfig::LOGIN_NAME;
    public static $password_name    = UserConfig::PASSWORD_NAME;
    public static $role_name        = UserConfig::ROLE_NAME;


    public static function GetAll()
    {
        return parent::Select('*', self::$table_name);
    }


    public static function GetByLogin($login)
    {
        $what = [
            self::$id_name,
            self::$login_name,
            self::$password_name,
            self::$role_name
        ];

        $where = [
            self::$login_name => $login
        ];
        return parent::Select($what, self::$table_name, $where, "LIMIT 1")[0];
    }


    public static function RegisterInsert($login, $password)
    {
        $what = [
            self::$id_name          => null,
            self::$login_name       => $login,
            self::$password_name    => $password
        ];
        return parent::Insert($what, self::$table_name);
    }
}