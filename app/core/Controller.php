<?php
/**
 * Base controller class
 * 
 * This file defines the base controller class, 'Controller', intended to be extended
 * by other controllers in a web application. The class includes methods for handling
 * the incoming request and rendering views. Controllers that extend this class should
 * ensure their constructor receives the request and calls the parent constructor.
 * 
 * The 'Controller' class has the following key components:
 * 
 * 1. **Constructor:**
 *    - Initializes the controller with the incoming request.
 * 
 * 2. **Render Method:**
 *    - Includes and displays a view file.
 *    - Accepts an optional array of data to pass to the view.
 *    - Throws a RuntimeException if the specified view file does not exist.
 * 
 * Usage Notes:
 * - Extend this 'Controller' class when creating new controllers.
 * - Ensure the constructor of the new controller accepts the request as a parameter
 *   and calls the parent constructor using 'parent::__construct($request);'.
 * - In controller methods, return a 'Response' object to send non-HTML responses.
 *   For example, 'return new Response("Access denied", 500);'.
 * - Make sure to store the controllers in app/controllers
 * 
 * @see Response
 */
class Controller{

    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function render($view, $data = array())
    {
        if(!file_exists('../app/views/' . $view . '.php'))
            throw new RuntimeException("View not found! Check filename to respect the standard!: $view");

        require_once '../app/views/' . $view . '.php';
    }
}