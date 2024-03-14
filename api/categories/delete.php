<?php

//Headers
include_once '../../config/Database.php';
include_once '../../models/Category.php';

//Instantiate DB and Connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$category = new Category($db);

//Get raw posted data
$data = json_decode(file_get_contents("php://input"));

//Set ID to update
$category->id = $data->id;

//delete post

if($category->delete()){
  echo json_encode(
    ['id' => $category->id]
  );
}else{
  echo json_encode(
  ['message' => 'category_id Not deleted']
);
}
