<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once 'index.php';
include_once '../../config/Database.php';
include_once '../../models/Quote.php';

//Instantiate DB and Connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$quote = new Quote($db);

//Get raw quoteed data
$data = json_decode(file_get_contents("php://input"));

// Validate the presence of required parameters
$missingParams = [];
if (empty($data->quote)) {
    $missingParams[] = 'quote';
}
if (empty($data->author_id)) {
    $missingParams[] = 'author_id';
}
if (empty($data->category_id)) {
    $missingParams[] = 'category_id';
}

// If there are missing parameters, respond with an error
if (!empty($missingParams)) {
    echo json_encode([
        'message' => 'Missing Required Parameters',
        'missing' => $missingParams
    ]);
    return;
}

$quote->quote = $data->quote;
$quote->author_id = $data->author_id;
$quote->category_id = $data->category_id;

//create post

if($quote->create()){
  echo json_encode(
    array('message' => 'Post Created')
  );
}else{
  echo json_encode(
    array('message'=> 'post_id Not Found')
  );
}