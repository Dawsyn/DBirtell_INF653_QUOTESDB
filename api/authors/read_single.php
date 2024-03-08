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
$authors_arr = array(
    'id' => $author->id,
    'author' => $author->author
  
  );
  
  //make JSON
  print_r(json_encode($authors_arr));

  if($author->id===null){
    echo json_encode(
      array('message' => 'author_id Not found'));
  }
