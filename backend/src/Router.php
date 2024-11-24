<?php

require_once dirname(__FILE__) . '/routes/MainRoutes.php';
require_once dirname(__FILE__) . '/controllers/CivicApiController.php';

/**
 * Handles all app routing and executes the right controller method
 * According to the routes map
 */
class Router
{
   
    private Array $requestPath;
    private string $requestMethod;
    private Array $mainRoutes;

    /**
     * [Description for __construct]
     *
     * 
     */
    public function __construct() 
    {
        $this->requestPath = explode('/', trim($_SERVER['REQUEST_URI']));
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
        $this->mainRoutes = MainRoutes::routes();
    }

    /**
     * Handles routes in format /action/{id}
     *
     * @return void
     */
    public function enable()
    {
        try {

            // preflight request handling
            if (strtolower(trim($this->requestMethod)) === 'options') {
                $this->handlePreFlightRequest();
            }

            // home-page, only for testing
            if ($_SERVER['REQUEST_URI'] === '/') {
                echo "Welcome, this is the app home";
                exit;
            }

            // first part of url is the controller action
            $action = $this->requestPath[1];

            // second part of url and id if needed
            $id = $this->requestPath[2] ?? null;

            // gets the controller acction according to the routes maping
            $controllerAction = isset($this->mainRoutes[$this->requestMethod][$action]) 
                ? $this->mainRoutes[$this->requestMethod][$action]
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

    /**
     * Handles the OPTIONS method preflight request
     *
     * @return void
     */
    private function handlePreFlightRequest()
    {
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
        exit;
    }
}