<?php

require_once( dirname(__FILE__) . '/Router.php' );

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