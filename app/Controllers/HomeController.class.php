<?php


namespace App\Controllers;


use App\Jobs\Auth\Auth;
use App\Lib\File\View;

class HomeController extends AbstractController
{
    public function index()
    {
        if (isset($_POST['auth']))
        {
            $auth = new Auth();
            $_SESSION['user'] = $auth->Login($_POST['login'], $_POST['password']);
        }

        if (isset($_POST['register']))
        {
            $auth = new Auth();
            $_SESSION['user'] = $auth->Register($_POST['login'], $_POST['password'], $_POST['confirm_password']);
        }

        if (isset($_POST['exit']))
        {
            session_unset();
            session_destroy();
        }

        View::ViewDir('pages/index.php');
    }


    public function test($params = null, ...$args)
    {

    }
}