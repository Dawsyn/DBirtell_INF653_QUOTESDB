<?php

include_once 'index.php';
include_once '../../config/Database.php';
include_once '../../models/Category.php';

//Instantiate DB and Connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$category = new Category($db);

//Get raw quoteed data
$data = json_decode(file_get_contents("php://input"));

// Validate the presence of required parameters

if (empty($data->category)) {
    $missingParams[] = 'category';
}

// If there are missing parameters, respond with an error
if (!empty($missingParams)) {
    echo json_encode([
        'message' => 'Missing Required Parameters',
        'missing' => $missingParams
    ]);
    return;
}



$category->category = $data->category;
//$category->id = $data->id;


//create post
if($category->create()){
  echo json_encode(['id' => $category->id, 'category' => $category->category]);
}else{
  echo json_encode(['message' => 'category_id Not Found']);
}
