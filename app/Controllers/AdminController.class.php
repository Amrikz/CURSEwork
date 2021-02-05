<?php


namespace App\Controllers;



use App\Lib\Route\Url;
use App\Models\Role;
use App\Models\Users;

class AdminController extends BaseController
{
    public function __construct()
    {
        if (!$_SESSION['user'])
        {
            header('Location: '.Url::getUrlAddition());
        }
        else
        {
            $user = Users::GetByID($_SESSION['user']['id']);
            $role = Role::GetByID($user['role_id']);
            if (!$role || $role['power'] < 3) header('Location: '.Url::getUrlAddition());
        }

        parent::__construct();
    }


    public function admin()
    {

    }
}