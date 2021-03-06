<?php


namespace App\Lib\Route;


use App\Lib\Logging\Logger;
use App\Lib\Request\Response;

class Route
{
    private static $_404 = 0;


    public static function done()
    {
        if (self::$_404 == 1)
        {
            header("HTTP/1.0 404 Not Found", true, 404);
        }
    }

    public static function get($destination_url, $controllerName, $actionName, $parameters = '')
    {
        $url = new Url();
        $url->setDestination($destination_url);
        if($url->compareUrl())
        {
            $args = $url->getArgs();
            // TODO: Here needs to be Token check
            $controller = new $controllerName();
            if(method_exists($controller, $actionName))
            {
                Logger::Info(__METHOD__, "$controllerName->$actionName");
                if (!$parameters) $response = $controller->$actionName(...$args);
                else $response =  $controller->$actionName($parameters, ...$args);
                Response::Json($response);
                die;
            }
            else
            {
                makeError("Method '$controllerName->$actionName' not found");
                die;
            }
        }
        else
        {
            self::$_404 = 1;
        }
    }
}