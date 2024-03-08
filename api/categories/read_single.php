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
$categories_arr = array(
    'id' => $category->id,
    'category' => $category->category
  );
  
  //make JSON
  print_r(json_encode($categories_arr));

 if($category->id===null){
    echo json_encode(
      array('message' => 'category_id Not found'));
  }
