<?php


namespace App\Lib\Route;


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
                $controller->$actionName($parameters, ...$args);
                die;
            }
            else
            {
                echo "Method not found";
                die;
            }
        }
        else
        {
            self::$_404 = 1;
        }
    }
}