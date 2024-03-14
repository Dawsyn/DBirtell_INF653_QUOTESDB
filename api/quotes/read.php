<?php

//Headers
include_once 'index.php';
include_once '../../config/Database.php';
include_once '../../models/Quote.php';

//Instantiate DB and Connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$post = new Quote($db);

// Check if author_id is provided in the query string
$author_id = isset($_GET['author_id']) ? $_GET['author_id'] : null;

// Use the modified read method, possibly with the author_id
$result = $post->read($author_id);


//Blog post query
//$result = $post->read();


//Get row count
$num = $result->rowCount();

//Check if any posts
if($num > 0){
  //Post array
  $posts_arr = array();

  while($row = $result->fetch(PDO::FETCH_ASSOC)){
    extract($row);

    $post_item = array(
    'id' => $id, 
    'quote' => $quote,
    'author' => $author_name,
    'category' => $category_name);

    //Push to 'data'
    array_push($posts_arr, $post_item);
  } 

  //Turn to JSON & Output
  echo json_encode($posts_arr);

} else {
  echo json_encode(['message' => 'No Quotes Found']);
}
