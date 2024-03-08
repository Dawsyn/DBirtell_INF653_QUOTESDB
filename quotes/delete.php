<?php

//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once 'index.php';
include_once '../../config/Database.php';
include_once '../../models/Quote.php';

//Instantiate DB and Connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$quote = new Quote($db);

//Get raw posted data
$data = json_decode(file_get_contents("php://input"));

//Set ID to update
$quote->id = $data->id;

//delete post

if($quote->delete()){
  echo json_encode(
    array('message' => 'Quote deleted')
  );
}else{
  echo json_encode(
    array('message'=> 'No Quotes Found')
  );
}