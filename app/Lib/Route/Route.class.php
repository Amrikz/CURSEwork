<?php


namespace App\Lib\Route;


use App\Lib\Errors\ErrProcessor;
use App\Lib\Logging\Logger;

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
                $controller->$actionName($parameters, ...$args);
                die;
            }
            else
            {
                ErrProcessor::MakeError("Method '$controllerName->$actionName' not found");
                die;
            }
        }
        else
        {
            self::$_404 = 1;
        }
    }
}