<?php


namespace Config;


class UserConfig
{
    //USER_DATABASE_TABLE
    const TABLE_NAME    = 'c_users';

    const ID_NAME       = 'id';
    const LOGIN_NAME    = 'login';
    const PASSWORD_NAME = 'password';
    const ROLE_NAME     = 'role';


    const MINIMAL_ADMIN_ROLE_LEVEL = 2;
}