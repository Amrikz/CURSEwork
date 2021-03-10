<?php


namespace App\Controllers;


use App\Lib\Route\Url;
use App\Models\Roles;
use App\Models\Users;

class AdminController extends BaseController
{
    public function __construct()
    {
        if (!$_SESSION['user'])
        {
            header('Location: '.url_addition());
        }
        else
        {
            $user = Users::GetByID($_SESSION['user']['id']);
            $role = Roles::GetByID($user['role_id']);
            if (!$role || $role['power'] < Roles::$admin_power_level) header('Location: '.url_addition());
        }

        parent::__construct();
    }


    public function index()
    {

    }
}