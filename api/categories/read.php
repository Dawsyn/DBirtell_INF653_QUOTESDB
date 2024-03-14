<?php

//Headers
include_once 'index.php';
include_once '../../config/Database.php';
include_once '../../models/Category.php';

//Instantiate DB and Connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$category = new Category($db);

//Blog post query
$result = $category->read();
//Get row count
$num = $result->rowCount();

//Check if any posts
if($num > 0){
  //Post array
  $categories_arr = array();

  while($row = $result->fetch(PDO::FETCH_ASSOC)){
    extract($row);

    $category_item = array(
    'id' => $id, 
    'category' => $category);

    //Push to 'data'
    array_push($categories_arr, $category_item);
  } 

  //Turn to JSON & Output
  echo json_encode($categories_arr);

} else {
  echo json_encode(['message' => 'category_id Not Found']);
}
