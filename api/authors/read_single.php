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

//get id
$author->id = isset($_GET['id']) ? $_GET['id'] : die();

//get post 
$author->read_single();

//create array
if(isset($author->author)){
  $author_arr = array(
    'id' => $author->id,
    'author' => $author->author
  );

  //turn to JSON & output
  echo json_encode($author_arr);
}else{
  echo json_encode(
  ['message' => 'author_id Not Found']);
}


 
    

