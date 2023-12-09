<?php

/**
 * File: init.php
 * 
 * Description: This PHP file serves as the entry point for the application's routing system.
 * It initializes the custom Router, handles incoming HTTP requests, and routes them to the
 * appropriate controllers and middleware.
 * 
 * Author: David - Robert Bratosin
 * Date: December 12, 2023
 * 
 * 
 * @version 0.2.0
 */

require_once 'Autoloader.php';
require_once 'core/Request.php';
require_once 'core/Response.php';
require_once 'core/Router.php';
require_once 'core/Controller.php';
require_once 'core/Middleware.php';
require_once 'core/Model.php';

error_reporting(E_ALL);
ini_set('display_errors', 'On');

$router = Router::getInstance();
$request = Request::parse();

$router->route($request);

?>
