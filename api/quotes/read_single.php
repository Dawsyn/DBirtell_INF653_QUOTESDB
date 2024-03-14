<?php

include_once 'index.php';
include_once '../../config/Database.php';
include_once '../../models/Quote.php';

//Instantiate DB and Connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$singleQuote = new Quote($db);

//get id
$singleQuote->id = isset($_GET['id']) ? $_GET['id'] : die();

//get post 
$singleQuote->read_single();

if(isset($singleQuote->quote)){
  //create array
  $quotes_arr = array(
    'id' => $singleQuote -> id, 
    'quote' => $singleQuote -> quote,
    'author' => $singleQuote -> author,
    'category' => $singleQuote -> category);

    //make JSON
    print_r(json_encode($quotes_arr));
}else{
    echo json_encode(
      ['message' => 'No Quotes Found']);
  }




