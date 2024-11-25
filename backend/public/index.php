<?php
/**
 * Main entry point for the application
 * Will load everything needed for the aplication to run
 */

// Allows access from any origin to allow frontend app to do request
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

// loads config variables
require_once dirname(__FILE__) . '/../src/config/config.php';
require_once dirname(__FILE__) . '/../src/App.php';

// starts App
new App();