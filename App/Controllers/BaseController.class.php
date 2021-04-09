<?php


namespace App\Controllers;


use App\Jobs\Auth\Auth;
use Bin\Framework\Lib\Format\Validator;
use Bin\Framework\Lib\Logging\Messages;
use Bin\Framework\Lib\Logging\Status;
use Bin\Framework\Lib\Route\Url;

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


    public static function sendResponse($message, $data = null, $code = 200)
    {
        if (!$data) $data = [];
        response(Status::NewResponse($message, $data)->GetArrStatus(), $code);
    }


    public static function sendError($message, $data = null, $code = 400)
    {
        response(Status::NewError($message, $data)->GetArrStatus(), $code);
    }


    public static function validateParams($rules, &$params, $message = null)
    {
        $validator = new Validator($rules);

        if ($validator->Validate($params))
        {
            return true;
        }
        else
        {
            $validator->Message($message);
            response($validator->Status());
            return false;
        }
    }
}