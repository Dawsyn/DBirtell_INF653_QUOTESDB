<?php
  class Author{
    //DB stuff
    private $conn;
    private $table = 'authors';

    //Post properties
    public $id;
    public $author;
    

    //Constructor
    public function __construct($db) {
      $this->conn = $db;
    }

    //Get posts
    public function read() {
      //Create query
      $query = 'SELECT 
          id,
          author
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
          author
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
      if($row){
        $this->id = $row['id'];
        $this->author = $row['author'];
      }else{
        $this->id = null;
        $this->author = null;
      }
    
    }

    public function update() {
      // update query
      $query = 'UPDATE ' . 
          $this->table . ' 
      SET 
        id = :id, 
        author = :author
      WHERE
       id = :id';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->author = htmlspecialchars(strip_tags($this->author));
      $this->id = htmlspecialchars(strip_tags($this->id));

      // Bind data
      $stmt->bindParam(':author', $this->author);
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
       (author) 
       VALUES 
       (:author)';


      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->author = htmlspecialchars(strip_tags($this->author));
      //$this->id = htmlspecialchars(strip_tags($this->id));

      // Bind data
      $stmt->bindParam(':author', $this->author);
      //$stmt->bindParam(':id', $this->id);
      
      // Execute query
      if($stmt->execute()) {
          // Retrieve and set the ID of the newly created quote
          $this->id = $this->conn->lastInsertId();
          return true;
      } else {
          return false;
      }
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
