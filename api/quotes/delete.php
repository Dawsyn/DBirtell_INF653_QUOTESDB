<?php

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
    ['id' => $quote->id]
  );
}else{
     echo json_encode(
      ['message' => 'No Quotes Found']
    );
  }

