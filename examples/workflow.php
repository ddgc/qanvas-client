<?php

/**
 * File: examples/workflow.php
 * Author: Robin Rijkeboer <rmrijkeboer@gmail.com>
 */

//Require the client
require_once('../lib/QanvasClient/Client.php');

//Setup client, first argument is the API key, second one is the Qanvas URL
$client = new QanvasClient\Client('b79a708ac2c9979b36e0465c04041d394035956db0377f9ca901ab7eb6303df3', 'http://localhost/qanvas-prototype/Master/web/app_dev.php');

//First we make some data:
$data = array(
    'color' => 'red',
    'name' => 'Qanvas Demo',
    'grades' => array(
        'rocketscience' => 5.3,
        'programmingskills' => 7.5,
        'nature' => 10.0,
        )
    );

//Now where is that document located that we wanted?
$file = "Doc/Workflow_example.odt";

//What format do we want?
$format = "pdf";

//Sends the document out for processing, you'll get back an array or an error if one is found.
$enqueuedDocument = $client->processDocument($file, $data, $format);

if ($enqueuedDocument['status'] == 0) {
    $token = $enqueuedDocument['token'];


    while ($client->checkDocumentStatus($token)['status'] == 0) {
        usleep(500000);
    }

    $processedDocument = $client->downloadDocument($token);

    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=workflow.' . $format);
    header('Content-Length: ' . strlen($processedDocument));
    echo $processedDocument;
    exit;

} else {
    die($enqueuedDocument['status']);
}
