<?php

/**
 * Router module for the MVC arhitecture. 
 * Responsable for handling requests made by the user.
 * Creates instance of the appropriate controller and executes the action invoked by the user.
 */

class Router{
    private static $instance = null;
    private $routesTable = null;
    
    private function __construct()
    {
        $this->routesTable = require_once 'Routes.php';
    }

    public static function getInstance()
    {
        if(self::$instance === null)
            self::$instance = new Router();

        return self::$instance;
    }

    public function route($descriptor, $method,$data)
    {
        $routes = $this->routesTable[$method];
        // find the route that matches the descriptor
        $route = $routes[$descriptor] ?? null;

        if($route === null)
        {
            // route not found
            http_response_code(404);
            die("Page not found.");
        }

        $controllerName = $route['controller'];
        $controllerFileName = '../app/controllers/' . $controllerName . '.php';

        if(!file_exists($controllerFileName))
        {
            // controller file was not found
            http_response_code(500);
            die("Controller not found.");
        }

        // create an instance of the controller
        require_once $controllerFileName;
        $controller = new $controllerName;

        // check if the action exists
        $actionName = $route['action'];
        if(!method_exists($controller,$actionName))
        {
            // action was not found
            http_response_code(500);
            die("Action not found.");
        }

        //execute the controller action
        call_user_func(array($controller,$actionName),...$data);
    }

}