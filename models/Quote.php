<?php
  class Quote{
    //DB stuff
    private $conn;
    private $table = 'quotes';

    //Post properties
    public $id;
    public $category_id;

    //Constructor
    public function __construct($db) {
      $this->conn = $db;
    }

    //Get posts
    public function read() {
      //Create query
      $query = 'SELECT 
          id,
          quote,
          author_id,
          category_id
        FROM
        ' . $this ->table ;

          
      //Prepare
      $stmt = $this -> conn -> prepare($query);
      //Execute
      $stmt -> execute();

      return $stmt;
    }

    //Get single post
    public function read_single(){
      $query = 'SELECT 
          id,
          quote,
          author_id,
          category_id
        FROM
        ' . $this ->table . '
        WHERE id = ?
    LIMIT 1';

     //Prepare
     $stmt = $this -> conn -> prepare($query);

     //bind ID
     $stmt->bindParam(1, $this->id);
     //Execute stmt
    $stmt->execute();

    $row = $stmt ->fetch(PDO::FETCH_ASSOC);

    //Set properties
    $this->id = $row['id'];
    $this->quote = $row['quote'];
    $this->category_id = $row['category_id'];
    $this->author_id = $row['author_id'];

    }

    public function update() {
      // update query
      $query = 'UPDATE ' . 
          $this->table . ' 
      SET 
        id = :id, 
        quote = :quote, 
        author_id = :author_id,
        category_id = :category_id
      WHERE
       id = :id';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->quote = htmlspecialchars(strip_tags($this->quote));
      $this->author_id = htmlspecialchars(strip_tags($this->author_id));
      $this->category_id = htmlspecialchars(strip_tags($this->category_id));
      $this->id = htmlspecialchars(strip_tags($this->id));

      // Bind data
      $stmt->bindParam(':quote', $this->quote);
      $stmt->bindParam(':author_id', $this->author_id);
      $stmt->bindParam(':category_id', $this->category_id);
      $stmt->bindParam(':id', $this->id);

      // Execute query
      if($stmt->execute()) {
        return true;
  }

  // Print error if something goes wrong
  printf("Error: %s.\n", $stmt->error);

  return false;
}

    // Create Post
    public function create() {
      // Create query
      $query = 'INSERT INTO ' . $this->table . '
       (quote, author_id, category_id) 
       VALUES 
       (:quote, :author_id, :category_id)';


      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->quote = htmlspecialchars(strip_tags($this->quote));
      $this->author_id = htmlspecialchars(strip_tags($this->author_id));
      $this->category_id = htmlspecialchars(strip_tags($this->category_id));

      // Bind data
      $stmt->bindParam(':quote', $this->quote);
      $stmt->bindParam(':author_id', $this->author_id);
      $stmt->bindParam(':category_id', $this->category_id);

      // Execute query
      if($stmt->execute()) {
        return true;
  }

  // Print error if something goes wrong
  printf("Error: %s.\n", $stmt->error);

  return false;
  }

  //Delete post 
  public function delete(){
    //create query
    $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

    //prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->id = htmlspecialchars(strip_tags($this->id));

    //bind data
    $stmt->bindParam(':id', $this->id);

    if($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
        
  }
}