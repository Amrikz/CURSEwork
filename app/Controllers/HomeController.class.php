<?php


namespace App\Controllers;


use App\Lib\File\View;

class HomeController extends BaseController
{
    public function index()
    {
        View::ViewDir('pages'.DIRECTORY_SEPARATOR.'index.php');
    }
}