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

//Blog post query
$result = $author->read();
//Get row count
$num = $result->rowCount();

//Check if any posts
if($num > 0){
  //Post array
  $authors_arr = array();

  while($row = $result->fetch(PDO::FETCH_ASSOC)){
    extract($row);

    $author_item = array(
    'id' => $id, 
    'author' => $author);

    //Push to 'data'
    array_push($authors_arr, $author_item);
  } 

  //Turn to JSON & Output
  echo json_encode($authors_arr);

} else {
  echo json_encode(
  ['message' => 'author_id Not Found']);
   
}
