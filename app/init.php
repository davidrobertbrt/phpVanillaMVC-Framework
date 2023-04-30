<?php
/**
 * Bootstraping for the modules responsable for the MVC Arhitecture.
 */

require_once 'core/Router.php';

$router = Router::getInstance();

//FIXME Move the code responsable for the URL Routing to another module.

$method = $_SERVER['REQUEST_METHOD'];
$uri = explode('/',filter_var(rtrim($_GET['url'],'/'),FILTER_SANITIZE_URL));
$requestData = array();

if(strcmp($method,'POST') === 0)
    $requestData = $_POST;

$router->route($method,$uri,$requestData);
