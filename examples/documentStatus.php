<?php

/**
 * File: examples/documentStatus.php
 * Author: Robin Rijkeboer <rmrijkeboer@gmail.com>
 */

//Require the client
require_once('../lib/QanvasClient/Client.php');

//Setup client, first argument is the API key, second one is the Qanvas URL
$client = new QanvasClient\Client('b79a708ac2c9979b36e0465c04041d394035956db0377f9ca901ab7eb6303df3', 'http://localhost/qanvas-prototype/Master/web/app_dev.php');

//Sends the token to check if the document is done, you'll get back an array or an error if one is found.
$result = $client->checkDocumentStatus('24cc9989646b804986b272ad9f060bad');

//For example purposes, die and show the variables in $result
die(var_dump($result));

//Examples what you can do with this:

//Check the status, 1 is processed, 0 is still processing.
if ($result['status'] == 1) {
    echo "The document has been processed.";
} else if ($result['status'] == 0) {
    echo "The document is still processing.";
}
