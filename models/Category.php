<?php
  class Category{
    //DB stuff
    private $conn;
    private $table = 'categories';

    //Post properties
    public $id;
    public $category;
    

    //Constructor
    public function __construct($db) {
      $this->conn = $db;
    }

    //Get posts
    public function read() {
      //Create query
      $query = 'SELECT 
          id,
          category
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
          category
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
    $this->category = $row['category'];

    }

    public function update() {
      // update query
      $query = 'UPDATE ' . 
          $this->table . ' 
      SET 
        id = :id, 
        category = :category
      WHERE
       id = :id';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->category = htmlspecialchars(strip_tags($this->category));
      $this->id = htmlspecialchars(strip_tags($this->id));

      // Bind data
      $stmt->bindParam(':category', $this->category);
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
       (id, category) 
       VALUES 
       (:id, :category)';


      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->id = htmlspecialchars(strip_tags($this->id));
      $this->category = htmlspecialchars(strip_tags($this->category));

      // Bind data
      $stmt->bindParam(':id', $this->id);
      $stmt->bindParam(':category', $this->category);

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