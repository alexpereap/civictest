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
     * @param Bool   $isPost
     * @param String $postFields
     * @param String $authHeader
     */
    public function __construct(
            String $url,
            Bool $isPost = false,
            String $postFields = null,
            String $authHeader = null
        )
    {

        $this->curl = curl_init();
        $curlConfig = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            
            CURLOPT_HTTPHEADER => array(
                ': ',
                'Content-Type: application/json'
            ),
        ];

        if ($isPost) {
            $curlConfig[CURLOPT_CUSTOMREQUEST] = 'POST';

            if ($postFields) {
                $curlConfig[CURLOPT_POSTFIELDS] = $postFields;
            }
        }

        if ($authHeader) {
            $curlConfig[CURLOPT_HTTPHEADER][] = 'Authorization: ' . $authHeader;
        }

        curl_setopt_array($this->curl, $curlConfig);
    }

    /**
     * Makes a request according to constructor settings
     *
     * @return json
     */
    public function makeRequest()
    {
        $response = curl_exec($this->curl);

        if (curl_errno($this->curl)) {
            return json_encode(
                [
                'success' => false,
                'error' => curl_error($this->curl),
                ]
            );
        } else {
            $jsonResponse = json_decode($response, true);

            // if jsonResponse is an object we successfully got data from API
            if (!is_null($jsonResponse)) {
                $jsonResponse['success'] = true;
                return $jsonResponse;
            }

            // something went wrong
            return [
                'success' => false,
                'error' => $response
            ];
        }

        curl_close($this->curl);
    }
}