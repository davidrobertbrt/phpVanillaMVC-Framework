<?php
/**
 * Bootstraping for the modules responsable for the MVC Arhitecture.
 */
require_once 'core/Router.php';
require_once 'core/Request.php';
require_once 'core/Controller.php';

$router = Router::getInstance();
$request = parseRequest();

$router->route(
    $request['descriptor'],
    $request['method'],
    $request['data']
);
