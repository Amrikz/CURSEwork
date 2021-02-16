<?php


namespace App\Controllers;


use App\Jobs\Builders\ViewBuilder;
use App\Lib\File\View;

class HomeController extends BaseController
{
    public function index()
    {
        ViewBuilder::build(['pages','index.php']);
        View::ViewDir(join(DIRECTORY_SEPARATOR,['blocks','lib','footer.php']));
    }
}