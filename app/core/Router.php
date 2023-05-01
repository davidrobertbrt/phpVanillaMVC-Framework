<?php

/**
 * Router module for the MVC arhitecture. 
 * Responsable for handling requests made by the user.
 * Creates instance of the appropriate controller and executes the action invoked by the user.
 */

class Router{
    private static $instance = null;
    private $routes = null;
    
    private function __construct()
    {
        $this->routes = require_once 'Routes.php';
    }

    public static function getInstance()
    {
        if(self::$instance === null)
            self::$instance = new Router();

        return self::$instance;
    }

    public function route($requestDescriptor, $requestMethod,$requestData)
    {
        
    }

}