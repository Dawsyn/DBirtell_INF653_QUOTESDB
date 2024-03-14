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

//get id
$category->id = isset($_GET['id']) ? $_GET['id'] : die();

//get post 
$category->read_single();

//create array
if(isset($category->category)){
  $categories_arr = array(
    'id' => $category->id,
    'category' => $category->category
  );

  //make JSON
   print_r(json_encode($categories_arr));
}else{
  echo json_encode(
  ['message' => 'category_id Not Found']);
}

  
  
 

    
  
