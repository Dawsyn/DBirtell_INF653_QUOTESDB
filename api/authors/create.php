<?php

include_once 'index.php';
include_once '../../config/Database.php';
include_once '../../models/Author.php';

//Instantiate DB and Connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$author = new Author($db);

//Get raw quoteed data
$data = json_decode(file_get_contents("php://input"));

// Validate the presence of required parameters
$missingParams = [];
if (empty($data->author)) {
    $missingParams[] = 'author';
}

// If there are missing parameters, respond with an error
if (!empty($missingParams)) {
    echo json_encode([
        'message' => 'Missing Required Parameters',
        'missing' => $missingParams
    ]);
    return;
}

$author->author = $data->author;
//$author->id = $data->id;


//create post

if($author->create()){
  echo json_encode(['id' => $author->id, 'author' => $author->author]);
}else{
  echo json_encode(['message' => 'author_id Not Found']);
}
