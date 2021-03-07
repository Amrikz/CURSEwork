<?php


namespace App\Lib\Route;


use App\Jobs\Auth\Auth;
use App\Lib\Logging\Logger;

class Route
{
    private static int $_404 = 0;
    private static array $_required_methods = [];


    private static function _routeBase($destination_url, $controllerName, $actionName, $parameters = null)
    {
        $url = new Url();
        $url->setDestination($destination_url);
        if($url->compareUrl())
        {
            $request = request();

            if (!self::_methodCheck($parameters['method'])) return false;
            $args = $url->getArgs();
            // TODO: Here needs to be Token check
            $controller = new $controllerName();
            if(method_exists($controller, $actionName))
            {
                Logger::Info(__METHOD__, "$controllerName->$actionName");
                $response = $controller->$actionName($request, ...$args);
                response($response);
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
            return false;
        }
    }


    private static function _methodCheck($required_method)
    {
        $current = $_SERVER['REQUEST_METHOD'];
        if ($required_method != null && $required_method != $current)
        {
            self::$_required_methods[] = $required_method;
            return false;
        }
        return true;
    }


    public static function done()
    {
        if (self::$_404 == 1)
        {
            header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
        }

        if (self::$_required_methods && !empty(self::$_required_methods))
        {
            makeError("This URL is not supporting ".$_SERVER['REQUEST_METHOD']." method. Supported methods:".arrayDataToStr(self::$_required_methods));
        }
    }


    public static function any($destination_url, $controllerName, $actionName, $parameters = null)
    {
        self::_routeBase($destination_url, $controllerName, $actionName, $parameters);
    }


    public static function get($destination_url, $controllerName, $actionName, $parameters = null)
    {
        $parameters['method'] = 'GET';
        self::_routeBase($destination_url, $controllerName, $actionName, $parameters);
    }


    public static function post($destination_url, $controllerName, $actionName, $parameters = null)
    {
        $parameters['method'] = 'POST';
        self::_routeBase($destination_url, $controllerName, $actionName, $parameters);
    }


    public static function put($destination_url, $controllerName, $actionName, $parameters = null)
    {
        $parameters['method'] = 'PUT';
        self::_routeBase($destination_url, $controllerName, $actionName, $parameters);
    }


    public static function delete($destination_url, $controllerName, $actionName, $parameters = null)
    {
        $parameters['method'] = 'DELETE';
        self::_routeBase($destination_url, $controllerName, $actionName, $parameters);
    }
}