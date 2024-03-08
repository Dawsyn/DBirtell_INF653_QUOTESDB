<?php

//Headers
include_once 'index.php';
include_once '../../config/Database.php';
include_once '../../models/Author.php';

//Instantiate DB and Connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$author = new Author($db);

//Get raw posted data
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

//Set IF to update
$author->id = $data->id;
$author->author = $data->author;


//update post

if($author->update()){
  echo json_encode(
    array('message' => 'Author Updated')
  );
}else{
  echo json_encode(
    array('message'=> 'author_id not Updated')
  );
}