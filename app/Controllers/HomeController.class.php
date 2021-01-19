<?php


namespace App\Controllers;


use App\Lib\File\View;

class HomeController extends AbstractController
{
    public function index()
    {
        View::ViewDir('pages'.DIRECTORY_SEPARATOR.'index.php');
    }
}