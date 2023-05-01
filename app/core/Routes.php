<?php

/**
 * File used to store all routes for the application. 
 * It separates each request based on the request data sent (either GET or POST)
 */

return array(
    'GET' => array(
        'home@index' => array('controller' => 'HomeController','action'=>'index')
    ),
    'POST' => array(),
);