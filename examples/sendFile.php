<?php

/**
 * File: examples/sendFile.php
 * Author: Robin Rijkeboer <rmrijkeboer@gmail.com>
 */

//Require the client
require_once('../lib/QanvasClient/Client.php');

//Setup client, first argument is the API key, second one is the Qanvas URL
$client = new QanvasClient\Client('b79a708ac2c9979b36e0465c04041d394035956db0377f9ca901ab7eb6303df3', 'http://localhost/qanvas-prototype/Master/web/app_dev.php');

//The path to the document
$pathToDocument = "/home/robin/Qanvas Update/Test documents/prooftemplate.odt";

//Data array, fill in anything that has been declared in the document here.
$dataArray = array(
    'dummy' => 'data'
    );

//Where does it need to convert to? Default is PDF so you can leave this blank
$format = "pdf";

//Sends the document out for processing, you'll get back an array or an error if one is found.
$result = $client->processDocument($pathToDocument, array(), $format);

//For example purposes, die and show the variables in $result
die(var_dump($result));
