<?php

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

//Set ID to update
$author->id = $data->id;

//delete post

if($author->delete()){
  echo json_encode(
    ['id' => $author->id]
  );
}else{
  echo json_encode(
    ['message' => 'author_id Not Deleted']
  );
}
