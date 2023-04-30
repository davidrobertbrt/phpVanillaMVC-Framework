<?php
/**
 * Module responsible for parsing the URL from the user.
 * Function returns a key-value array in which it is specified:
 * - the method used for the request (either GET / POST)
 * - the uri which will be processed by the Router
 * - the request data which is sent using POST.
 */

function parseRequest(){
    $method = $_SERVER['REQUEST_METHOD'];
    $uri = explode('/',filter_var(rtrim($_GET['url'],'/'),FILTER_SANITIZE_URL));
    $requestData = array();

    if(strcmp($method,'POST') === 0)
        $requestData = $_POST;

    return array(
        'method' => $method,
        'uri' => $uri,
        'requestData' => $requestData
    );
}