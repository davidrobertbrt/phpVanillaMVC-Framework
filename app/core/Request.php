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
    $controller = $uri[0] ?? null;
    $action = $uri[1] ?? null;
    $method = $_SERVER['REQUEST_METHOD'];
    $requestData = array(
        'GET' => array_values(array_slice($uri,2)),
        'POST' => ($_SERVER['REQUEST_METHOD'] === 'POST') ? $_POST : []
    );

    return array(
        'descriptor' => $controller . '@' . $action,
        'requestMethod' => $method,
        'requestData' => $requestData
    );

}