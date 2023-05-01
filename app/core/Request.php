<?php
/**
 * Module responsible for parsing the URL from the user.
 * Function returns a key-value array in which it is specified:
 * - the descriptor which separates the controller and the action
 * - the method used for the request (GET/POST)
 * - the request data which is sent (GET/POST)
 * 
 * @return array An associative array containing parsed information about the request.
 */

function parseRequest(){
    $uri = explode('/',filter_var(rtrim($_GET['url'],'/'),FILTER_SANITIZE_URL));
    $controller = $uri[0] ?? null;
    $action = $uri[1] ?? null;
    $method = $_SERVER['REQUEST_METHOD'];
    $requestData = array(
        'GET' => (count($uri) > 2) ? array_values(array_slice($uri,2)) : array(),
        'POST' => ($_SERVER['REQUEST_METHOD'] === 'POST') ? $_POST : array()
    );

    return array(
        'descriptor' => $controller . '@' . $action,
        'method' => $method,
        'data' => $requestData
    );

}