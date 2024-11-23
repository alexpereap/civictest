<?php

require_once( dirname(__FILE__) . '/Router.php' );

// Allows access from any origin to allow frontend app to do request
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

/**
 * MAIN APP class
 */
class App
{
    public function __construct()
    {
        $router = new Router;
        $router->enable();
    }
}