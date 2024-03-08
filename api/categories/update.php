<?php

//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once 'index.php';
include_once '../../config/Database.php';
include_once '../../models/Category.php';

//Instantiate DB and Connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$category = new Category($db);

//Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Validate the presence of required parameters
$missingParams = [];
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

//Set IF to update
$category->id = $data->id;
$category->category = $data->category;

//update post

if($category->update()){
  echo json_encode(
    array('message' => 'Category Updated')
  );
}else{
  echo json_encode(
    array('message'=> 'Category Not Updated')
  );
}