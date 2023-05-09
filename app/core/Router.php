<?php

/**
 * Router module for the MVC arhitecture. 
 * Responsable for handling requests made by the user.
 * Creates instance of the appropriate controller and executes the action invoked by the user.
 */

final class Router{
    private static $instance = null;
    private $routesTable = null;
    private $middlewaresTable = null;
    
    private function __construct()
    {
        $this->routesTable = require_once 'Routes.php';
        $this->middlewaresTable = require_once 'Middlewares.php';
    }

    public static function getInstance()
    {
        if(self::$instance === null)
            self::$instance = new Router();

        return self::$instance;
    }

    public function route($request)
    {
        $descriptor = $request->getDescriptor();
        $method = $request->getMethod();
        $data = $request->getData();

        $routes = $this->routesTable[$method];
        // find the route that matches the descriptor
        $route = $routes[$descriptor] ?? null;

        if($route === null)
        {
            // route not found
            $response = new Response("Page not found.",404);
            $response->send();
            exit();
        }

        ///middleware calling should be handled here.
        $middlewares = $this->middlewaresTable[$descriptor];

        foreach($middlewares as $middlewareName)
        {
            $middlewareFilename = '../app/middlewares/' . $middlewareName . '.php';

            if (!file_exists($middlewareFilename)) 
            {
                $response = new Response("Middleware not found: $middlewareFilename",500);
                $response->send();
                exit();
            }

            require_once $middlewareFilename;

            $middleware = new $middlewareName;
            $data = $middleware($data);
            // check if middleware returned a response
            if($data instanceof Response)
            {
                $data->send();
                exit();
            }
        }

        $response->setData($data);

        $controllerName = $route['controller'];
        $controllerFileName = '../app/controllers/' . $controllerName . '.php';

        if(!file_exists($controllerFileName))
        {
            // controller file was not found
            $response = new Response("Controller not found.",500);
            $response->send();
            exit();
        }

        // create an instance of the controller
        require_once $controllerFileName;
        $controller = new $controllerName($request);

        // check if the action exists
        $actionName = $route['action'];
        if(!method_exists($controller,$actionName))
        {
            // action was not found
            $response = new Response("Action not found.",500);
            $response->send();
            exit();
        }

        // execute the controller action
        $controller->$actionName();
    }
}