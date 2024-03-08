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

//create array
$quotes_arr = array(
    'id' => $singleQuote->id,
    'quote' => $singleQuote->quote,
    'category_id' => $singleQuote->category_id,
    'author_id' => $singleQuote->author_id
  
  );
  
  //make JSON
  print_r(json_encode($quotes_arr));

  if($singleQuote->id===null){
    echo json_encode(
      array('message' => 'No Quotes Found'));
  }
