<?php
/**
 * Bootstraping for the modules responsable for the MVC Arhitecture.
 */
require_once 'core/Router.php';
require_once 'core/Request.php';
require_once 'core/Response.php';
require_once 'core/Controller.php';
require_once 'core/Middleware.php';
require_once 'core/Model.php';
require_once 'core/Cookie.php';

$router = Router::getInstance();
$request = Request::parse();

$router->route($request);
