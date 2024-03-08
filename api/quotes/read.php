<?php

include_once 'index.php';
include_once '../../config/Database.php';
include_once '../../models/Quote.php';

//Instantiate DB and Connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$post = new Quote($db);

//Blog post query
$result = $post->read();
//Get row count
$num = $result->rowCount();

//Check if any posts
if($num > 0){
  //Post array
  $posts_arr = array();
  $posts_arr ['data'] = array();

  while($row = $result->fetch(PDO::FETCH_ASSOC)){
    extract($row);

    $post_item = array(
    'id' => $id, 
    'author_id' => $author_id,
    'quote' => $quote,
    'category_id' =>$category_id);

    //Push to 'data'
    array_push($posts_arr['data'], $post_item);

    //Turn to JSON & Output
    echo json_encode($posts_arr);
  } 

} else {
  echo json_encode(
    array('message' => 'No Quotes Found'));
}