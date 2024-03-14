<?php

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

if (!isset($data->author_id) || empty($data->author_id)) {
    $missingParams[] = 'author_id';
} else if (!$quote->authorExists($data->author_id)) {
    echo json_encode(['message' => 'author_id Not Found']);
    return;
}

if (!isset($data->category_id) || empty($data->category_id)) {
    $missingParams[] = 'category_id';
} else if (!$quote->categoryExists($data->category_id)) {
    echo json_encode(['message' => 'category_id Not Found']);
    return;
}

if (!empty($missingParams)) {
    echo json_encode([
        'message' => 'Missing Required Parameters'
    ]);
    return;
}

$quote->quote = $data->quote;
$quote->author_id = $data->author_id;
$quote->category_id = $data->category_id;

//create post

if($quote->create()){
echo json_encode(['id' => $quote->id, 'quote' => $quote->quote, 'author_id' => $quote->author_id, 'category_id' => $quote->category_id]);
}else{
  echo json_encode(['message' => $missingParams . ' Not Found']);
}
