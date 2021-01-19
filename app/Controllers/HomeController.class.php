<?php


namespace App\Controllers;


use App\Jobs\Auth\Auth;
use App\Lib\File\View;
use App\Models\Users;

class HomeController extends AbstractController
{
    public function index()
    {
        View::ViewDir('pages'.DIRECTORY_SEPARATOR.'index.php');
    }


    public function test()
    {
        var_dump(Users::GetAll());
        $auth = new Auth();
        $auth->Register('qeq','qweqwe','qweqwe');
    }
}