<?php


namespace App\Controllers;


use App\Jobs\Auth\Auth;
use App\Lib\Logging\Messages;
use App\Lib\Route\Url;

abstract class BaseController
{
    public function __construct()
    {
        if ($_POST['auth'])
        {
            if ($_SESSION['user'])
            {
                Messages::Error("Вы уже авторизованы!");
            }
            else
            {
                Auth::Login($_POST['login'], $_POST['password']);
            }
        }
        elseif ($_POST['register'])
        {
            if ($_SESSION['user'])
            {
                header('Location: '.Url::getUrlAddition());
            }
            else Auth::Register($_POST['login'], $_POST['password'], $_POST['c_password']);
        }

        if ($_POST['exit'])
        {
            session_unset();
            session_destroy();
        }
    }
}