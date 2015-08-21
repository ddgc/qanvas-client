<?php

/**
 * File: lib/QanvasClient/Client.php
 * Author: Robin Rijkeboer <rmrijkeboer@gmail.com>
 */

namespace QanvasClient;

class Client
{

    private $apiKey;
    private $url;

    /**
     * Initializes the class
     * @param string $apiKey API key issued by Qanvas
     * @param string $url    The url to Qanvas
     */
    public function __construct($apiKey, $url)
    {
        $this->apiKey = $apiKey;
        $this->url = $url;
    }

    /**
     * Send a document to the Qanvas servers
     * @param  string $document Full path to the document file
     * @param  array  $data     data used in the document
     * @param  string $format   Which format do you want to process it to?
     * @return array            The response of the qanvas server
     */
    public function processDocument($document, array $data, $format = 'pdf')
    {
        $payload = array(
            'template' => curl_file_create($document),
            'data' => json_encode($data),
            'format' => $format,
            );

        $response = $this->sendCurl($payload, 'documents');

        return json_decode($response, true);
    }

    /**
     * Downloads the document
     * @param  string $token The token provided by processDocument
     * @return string        The document in string format
     */
    public function downloadDocument($token)
    {
        $payload = array(
            'token' => $token,
            );

        $response = $this->sendCurl($payload, 'download', false);

        return $response;
    }

    /**
     * Send a token to check the status of your document
     * @param  string $token token provided by processDocument
     * @return array
     */
    public function checkDocumentStatus($token)
    {
        $payload = array(
            'token' => $token,
            );

        $response = $this->sendCurl($payload, 'document', false);

        return json_decode($response, true);
    }

    /**
     * Sends a curl request to the Qanvas server
     * @param  array  $payload  payload
     * @param  string  $path    qanvas path
     * @param  boolean $isPost  if false sends as get
     * @return string           response
     */
    private function sendCurl($payload, $path, $isPost = true)
    {
        //Start CURL request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: multipart/form-data'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        if ($isPost) {
            curl_setopt($ch, CURLOPT_URL, $this->url . "/". $path ."?key=" . $this->apiKey);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        } else {
            $payloadString = http_build_query($payload);
            curl_setopt($ch, CURLOPT_URL, $this->url . "/". $path ."?key=" . $this->apiKey . "&" . $payloadString);
        }

        $response = curl_exec($ch);

        return $response;
    }
}
