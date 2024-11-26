<?php
/**
 * App config variables
 */

// CIVICPLUS API CONFIG
define('CLIENT_ID', getenv('CLIENT_ID'));
define('CLIENT_SECRET', getenv('CLIENT_SECRET'));
define('API_BASE_URL', getenv('API_BASE_URL'));

// REDIS CONFIG
define('REDIS_HOST', getenv('REDIS_HOST'));
define('REDIS_PORT', getenv('REDIS_PORT'));

// FRONT END HOSTNAME CONFIG (used by index.php Access-Control-Allow-Origin)
define('FRONTEND_HOSTNAME', getenv('FRONTEND_HOSTNAME'));
