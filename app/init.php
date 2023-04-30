<?php
/**
 * Bootstraping for the modules responsable for the MVC Arhitecture.
 */

require_once 'core/Router.php';
require_once 'core/Request.php';

$router = Router::getInstance();
$request = parseRequest();

$router->route($request['method'],$request['uri'],$request['requestData']);
