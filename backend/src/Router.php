<?php

require_once (  dirname(__FILE__) . '/routes/CivicApiRoutes.php');
require_once (  dirname(__FILE__) . '/controllers/CivicApiController.php');

/**
 * Handles all app routing and executes the right controller method
 * According to the routes map
 */
class Router
{   
    private Array $requestPath;
    private string $requestMethod;
    private Array $civicApiRoutes;

    public function __construct() 
    {
        $this->requestPath = explode('/', trim($_SERVER['REQUEST_URI']));
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
        $this->civicApiRoutes = CivicApiRoutes::routes();
    }

    /**
     * Handles routes in format /action/{id}
     *
     * @return void
     * 
     */
    public function enable()
    {
        try {
            // home page
            if ($_SERVER['REQUEST_URI'] === '/') {
                echo "THE TEST HOME :)";
                exit;
            }

            // first part of url is the controller action
            $action = $this->requestPath[1];

            // second part of url and id if needed
            $id = $this->requestPath[2] ?? null;

            // gets the controller acction according to the routes maping
            $controllerAction = isset($this->civicApiRoutes[$this->requestMethod][$action]) 
                ? $this->civicApiRoutes[$this->requestMethod][$action]
                : false;

            if ($controllerAction) {
                $civicApiController = new CivicApiController;
                
                // gets params from request body
                $params = file_get_contents('php://input') ?: null;
                if ($params) {
                    $params = json_decode($params, true);
                }

                // calls controller 
                $civicApiController->{$controllerAction}($params, $id);
                exit;

            }

            // 404 zone
            header("HTTP/1.0 404 Not Found");
            echo '<h1>404 NOT FOUND</h1>';
            exit;

        } catch (Exception $e) {
            echo 'Unexpected error occurred:' . $e->getMessage();
        }
    }
}