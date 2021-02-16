<?php


namespace App\Controllers;


use App\Jobs\Builders\ViewBuilder;
use App\Lib\File\View;

class HomeController extends BaseController
{
    public function index()
    {
        $GLOBALS['head_params']['links'] = [
            "<link rel='stylesheet' href='/public/css/welcome.css'>",
        ];

        ViewBuilder::build(['pages','index.php']);
        View::ViewDir(join(DIRECTORY_SEPARATOR,['blocks','lib','footer.php']));
    }
}