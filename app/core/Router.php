<?php

/**
 * Router Module for the MVC Architecture
 * 
 * This module handles requests made by the user in the MVC architecture.
 * It creates an instance of the appropriate controller and executes the action
 * invoked by the user. The router utilizes a mapping table to determine the
 * appropriate route based on the HTTP method and descriptor.
 * 
 * @final
 */

final class Router{
    private static $instance = null;
    private $mappingTable = null;
    private $currentController = null;
    
    private function __construct()
    {
        $this->mappingTable = require_once '../app/config/Mapping.php';
    }

    public static function getInstance()
    {
        if(self::$instance === null)
            self::$instance = new Router();

        return self::$instance;
    }

    public function route($request)
    {
        if((!$request instanceof Request)){
            throw new InvalidArgumentException("A request object was not sent to the router!");
        }

        $method = $request->getMethod();
        $routes = $this->mappingTable[$method];

        if(count($routes) === 0){
            throw new InvalidArgumentException("No routes have been defined for this request method. Check mapping file.");
        }

        $descriptor = $request->getDescriptor();

        if(isset($routes[$descriptor]))
            $currentRoute = $routes[$descriptor];
        else
            $currentRoute = null;

        if(!isset($currentRoute))
        {
            $response = new Response("Page not found.",404);
            $response->send();
            return;
        }

        // executing the middlewares for the current route
        foreach($currentRoute['middlewares'] as $middlewareEntry)
        {
            // creating a middleware object and invoking it
            $currentMiddleware = new $middlewareEntry;
            $output = $currentMiddleware($request);


            // if the output is a non html response we just send it.
            if($output instanceof Response)
            {
                $output->send();
                return;
            }

            // if the output is still a request but modified, we should just pass it as the new request to the router.
            if( !($output instanceof Request) ){
                throw new UnexpectedValueException("Return value of middleware is not a Request or Response object!");
            } else {
                $request = $output;
            }
        }

        // if the handler is a callable function
        if(is_callable($currentRoute['handler']))
        {
            $reflection = new ReflectionFunction($currentRoute['handler']);

            if($reflection->getNumberOfParameters() > 1)
                throw new InvalidArgumentException("Callable function has more parameters. Callable functions only get the request as a parameter: $descriptor");

            if($reflection->getNumberOfParameters() === 1)
                $output = $currentRoute['handler']($request);
            else
                $output = $currentRoute['handler']();

            // if the function does not return anything, we shouldn't check any instance of
            if(!isset($output))
                return;

            if($output instanceof Response)
            {
                $output -> send();
                return;
            }

            if(!($output instanceof Request))
                throw new RuntimeException("Callable functions should return either a Request or a Response!: $descriptor");
        }

        // getting the controller and action to call
        $currentHandler = $currentRoute['handler'];

        if( !($this->currentController instanceof $currentHandler[0]) )
            $this->currentController = new $currentHandler[0]($request);

        $actionName = $currentHandler[1];

        if(!method_exists($this->currentController,$actionName)){
            throw new RuntimeException("Action not found: $actionName");
        }

        $output = $this->currentController->$actionName();
        
        // if the controller just sends a response we should treat it as is.
        if($output instanceof Response)
        {
            $output->send();
            return;
        }
    }
}