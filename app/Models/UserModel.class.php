<?php


namespace App\Models;


use Config\UserConfig;

class UserModel extends AbstractModel implements ModelInterface
{
    public static $table_name       = UserConfig::TABLE_NAME;

    public static $id_name          = UserConfig::ID_NAME;
    public static $login_name       = UserConfig::LOGIN_NAME;
    public static $password_name    = UserConfig::PASSWORD_NAME;
    public static $role_name        = UserConfig::ROLE_NAME;
}