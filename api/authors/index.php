<?php

//Headers
header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'OPTIONS') {
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
        exit();
    }

if ($method === 'GET') {
    // Check if an 'id' parameter is present in the URL
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        // If an 'id' is provided, include the script for a single resource
        include_once 'read_single.php';
    } else {
        // If no 'id' is provided, include the script to read all resources
        include_once 'read.php';
    }
}

if ($method === 'POST')
  include_once 'create.php';

if ($method === 'PUT') 
  include_once 'update.php';

if ($method === 'DELETE')
  include_once 'delete.php';  
