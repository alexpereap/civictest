<?php

/**
 * A helper for making curl request
 */
class CurlRequestHelper
{
    private CurlHandle $curl;

    /**
     *
     * @param String $url
     * @param String $action ('GET', 'POST')
     * @param String|null $postFields
     * @param String|null $authHeader
     */
    public function __construct(
        String $url,
        String $action = 'GET',
        ?String $postFields = null,
        ?String $authHeader = null
    ) {
        $this->curl = curl_init();

        $curlConfig = $this->getDefaultCurlConfig($url);

        // Configure curl based on action
        $this->configureAction($curlConfig, $action, $postFields);

        // Add Authorization header if provided
        if ($authHeader) {
            $curlConfig[CURLOPT_HTTPHEADER][] = 'Authorization: ' . $authHeader;
        }

        curl_setopt_Array($this->curl, $curlConfig);
    }

    /**
     * Get default cURL configuration.
     *
     * @param String $url
     * @return Array
     */
    private function getDefaultCurlConfig(String $url)
    {
        return [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
            ],
        ];
    }

    /**
     * Configure cURL options based on action.
     *
     * @param Array $curlConfig
     * @param String $action
     * @param String|null $postFields
     */
    private function configureAction(Array &$curlConfig, String $action, ?String $postFields)
    {
        $curlConfig[CURLOPT_CUSTOMREQUEST] = $action;

        if ($action === 'POST' && $postFields) {
            $curlConfig[CURLOPT_POSTFIELDS] = $postFields;
        }
    }

    /**
     * Makes a request according to constructor settings
     *
     */
    public function makeRequest()
    {
        $response = curl_exec($this->curl);

        if (curl_errno($this->curl)) {
            return [
                'success' => false,
                'error' => curl_error($this->curl),
            ];
        } else {
            $jsonResponse = json_decode($response, true);

            if (!is_null($jsonResponse)) {
                $jsonResponse['success'] = true;
                return $jsonResponse;
            }

            return [
                'success' => false,
                'error' => $response
            ];
        }

        curl_close($this->curl);
    }
}
