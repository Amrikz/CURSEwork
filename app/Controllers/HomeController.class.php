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
        /*Users::GetAll();
        $auth = new Auth();
        var_dump($auth->Register('qeq','qweqwe','qweqwe'));
        echo '<br><br>';
        var_dump($auth->GetArrStatus());
        echo '<br><br>';
        var_dump($auth->Login('qeq','qweqwe'));
        echo '<br><br>';
        var_dump($auth->GetArrStatus());*/
    }
}