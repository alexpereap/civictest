<?php

require_once dirname(__FILE__) . '/../utils/CurlRequestHelper.php';

class CivicApiController
{

    private Redis $redis;
    private String $bearerToken;
    private String $accessToken;

    public function __construct()
    {   
        // ALL responses default to json type
        header('Content-Type: application/json; charset=utf-8');

        // redis init
        $this->redis = new Redis();
        $this->redis->connect(REDIS_HOST, REDIS_PORT);

        // init value for bearer token
        $this->setBearerToken();
    }

    /**
     * Controller for /events/{?id} endpoint
     *
     * @return void
     */
    public function getEvents($params = null, String $id = null)
    {
        // use all events or single event url
        $url = $id ? API_BASE_URL . '/Events/' . $id : API_BASE_URL . '/Events';

        $curlRequest = new CurlRequestHelper(
            $url,
            false,
            null,
            $this->bearerToken,
        );

        $response = $curlRequest->makeRequest();
        echo json_encode($response);
    }

    public function postEvent(Array $params)
    {

        // format dates
        $params['startDate'] = date('Y-m-d H:i:s', strtotime($params['startDate']));
        $params['endDate'] = date('Y-m-d H:i:s', strtotime($params['endDate']));

        $payload = json_encode($params);
        $curlRequest = new CurlRequestHelper(
            API_BASE_URL . '/Events',
            true,
            $payload,
            $this->bearerToken
        );

        $response = $curlRequest->makeRequest();
        echo json_encode($response);
    }

    /**
     * Sets the bearer token either from API request 
     * or by getting it from redis cache
     *
     * @return void
     */
    private function setBearerToken()
    {   
        $accessToken = $this->redis->get('access_token');

        // sets bearer token from redis if exists
        if ($accessToken) {
            $this->accessToken = $accessToken;
            $this->bearerToken = 'Bearer ' . $accessToken;
            return;
        }

        $payload = [
            "clientId" => CLIENT_ID,
            "clientSecret" => CLIENT_SECRET,
        ];
        
        $payload = json_encode($payload);

        // gets bearer token from api call
        $curlRequest = new CurlRequestHelper(
            API_BASE_URL . '/Auth',
            true,
            $payload
        );

        $response = $curlRequest->makeRequest();

        if ($response['success'] === true && isset($response['access_token'])) {
            $this->accessToken = $response['access_token'];
            $this->bearerToken = 'Bearer ' . $this->accessToken;

            // stores token in redis cache
            $this->redis->set('access_token', $this->accessToken, $response['expires_in']);
        } else {
            throw new Exception('Unable to get authentication token for API');
        }        

    }

}