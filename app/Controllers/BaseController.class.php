<?php


namespace App\Controllers;


use App\Jobs\Auth\Auth;
use App\Lib\Logging\Messages;
use App\Lib\Route\Url;

abstract class BaseController
{
    public function __construct()
    {
        $request = request();
        
        if ($request['auth'])
        {
            if (Auth::$user)
            {
                Messages::Error("Вы уже авторизованы!");
            }
            else
            {
                Auth::Login($request);
            }
        }
        elseif ($request['register'])
        {
            if (Auth::$user)
            {
                header('Location: '.Url::getUrlAddition());
            }
            else Auth::Register($request);
        }

        if ($request['exit'])
        {
            session_unset();
            session_destroy();
            header('Location: '.Url::getUrlAddition());
        }
    }
}