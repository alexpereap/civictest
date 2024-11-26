<?php
/**
 * Main entry point for the application
 * Will load everything needed for the aplication to run
 */

// loads config variables
require_once dirname(__FILE__) . '/../src/config/config.php';
require_once dirname(__FILE__) . '/../src/App.php';

// Allows access from only frontend hostname
header('Access-Control-Allow-Origin: ' . FRONTEND_HOSTNAME);

// starts App
new App();