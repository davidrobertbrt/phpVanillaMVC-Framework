<?php

/**
 * Router module for the MVC arhitecture. 
 * Responsable for handling requests made by the user.
 * Creates instance of the appropriate controller and executes the action invoked by the user.
 */

class Router{
    private static $instance = null;
    
    private function __construct()
    {
        
    }

    public static function getInstance()
    {
        if(self::$instance === null)
            self::$instance = new Router();

        return self::$instance;
    }

    public function route($method,$uri,$requestData = array())
    {
        print_r($uri);
        echo '<br>';
        echo $method;
        echo '<br>';
        print_r($requestData);
    }

}