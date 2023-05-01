<?php
/**
 * Module responsible for parsing the URL from the user.
 * Function returns a key-value array in which it is specified:
 * - the controller which is called
 * - the action requested
 * - the method used for the request (either GET / POST)
 * - the request data which is sent using POST / GET.
 */

function parseRequest(){
    $uri = explode('/',filter_var(rtrim($_GET['url'],'/'),FILTER_SANITIZE_URL));

    $controller = null;
    $action = null;
    $method = $_SERVER['REQUEST_METHOD'];
    $requestData = array('GET'=>array(),'POST'=>array());

    if(isset($uri[0]))
    {
        $controller = $uri[0];
        unset($uri[0]);
    }

    if(isset($uri[1]))
    {
        $action = $uri[1];
        unset($uri[1]);
    }

    if(count($uri) > 0)
    {
        $requestData['GET'] = array_values($uri);
        unset($uri);
    }

    if(strcmp($method,'POST') === 0)
        $requestData[$method] = $_POST;

    return array(
        'controller' => $controller,
        'action' => $action,
        'method' => $method,
        'requestData' => $requestData
    );
}