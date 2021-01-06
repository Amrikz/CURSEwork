<?php


namespace App\Controllers;


use App\Jobs\Auth\Auth;
use App\Lib\Database\DB;
use App\Lib\File\View;
use App\Lib\Logging\Status;

class HomeController extends AbstractController
{
    public function index()
    {
        if ($_POST['auth'])
        {
            $auth = new Auth();
            $_SESSION['user'] = $auth->Login($_POST['login'], $_POST['password']);
        }

        if ($_POST['register'])
        {
            //Auth::Register($_POST['login'], $_POST['password'], $_POST['confirm_password']);
        }

        if ($_POST['exit'])
        {
            session_unset();
            session_destroy();
        }

        View::ViewDir('index.php');
        //View::RelDir(Config::VIEW_DIR . "index.php");
        //View::AbsDir(PROJECT_DIR . Config::VIEW_DIR . "index.php");
    }


    public function test($params = null, ...$args)
    {
        $conn = new DB;
        var_dump($conn);

        echo "<br><br>";

        var_dump($params);

        echo "<br><br>";

        var_dump($args);

        echo "<br><br>";

        $status = new Status();
        $status->SwitcherRegister('0','message','Вы успешно авторизировались!');
        var_dump($status);
        $status->StatusSwitch(0);
        echo "<br><br>";
        var_dump($status->status["message"]);
    }
}