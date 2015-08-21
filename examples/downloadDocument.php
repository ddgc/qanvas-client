<?php

/**
 * File: examples/downloadDocument.php
 * Author: Robin Rijkeboer <rmrijkeboer@gmail.com>
 */

//Require the client
require_once('../lib/QanvasClient/Client.php');

//Setup client, first argument is the API key, second one is the Qanvas URL
$client = new QanvasClient\Client('b79a708ac2c9979b36e0465c04041d394035956db0377f9ca901ab7eb6303df3', 'http://localhost/qanvas-prototype/Master/web/app_dev.php');

//
$result = $client->downloadDocument('5ffc6876821c184bf78934a7e3e7d49c');

header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=test.pdf');
header('Content-Length: ' . strlen($result));
echo $result;
exit;
//die(var_dump($result));
