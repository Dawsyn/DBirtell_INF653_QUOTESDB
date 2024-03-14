<?php
  class Quote{
    //DB stuff
    private $conn;
    private $table = 'quotes';

    //Post properties
    public $id;
    public $category;
    public $quote;
    public $author;
    public $author_id;
    public $category_id;

    //Constructor
    public function __construct($db) {
      $this->conn = $db;
    }

    //Get posts
    public function read($author_id = null) {
      //Create query
      $query = 'SELECT
      q.id,
      q.quote,
      a.author AS author_name,
      c.category AS category_name 
      FROM
      quotes q
      LEFT JOIN authors a ON q.author_id = a.id
      LEFT JOIN categories c ON q.category_id = c.id';
          
      // If an author_id is provided, add a WHERE clause to filter by author_id
      if ($author_id !== null) {
          $query .= ' WHERE q.author_id = :author_id';
      }

      $stmt = $this->conn->prepare($query);

      // If an author_id is provided, bind it to the query
      if ($author_id !== null) {
          $stmt->bindParam(':author_id', $author_id, PDO::PARAM_INT);
      }

      $stmt->execute();
      return $stmt;
    }

    //Get single post
    public function read_single(){
      $query = 'SELECT
        q.id,
        q.quote,
        a.author AS author_name,
        c.category AS category_name 
        FROM
        quotes q
        LEFT JOIN authors a ON q.author_id = a.id
        LEFT JOIN categories c ON q.category_id = c.id
        WHERE q.id = ?
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
        $this->quote = $row['quote'];
        $this->author = $row['author_name'];
        $this->category = $row['category_name'];
      }else{
      // If no row is returned, explicitly set properties to indicate no data found
      $this->id = null;
      $this->quote = null;
      $this->author = null;
      $this->category = null;
      }
    }

    public function update() {

      $checkQuery = "SELECT COUNT(*) FROM " . $this->table . " WHERE id = :id";
      $checkStmt = $this->conn->prepare($checkQuery);
      $checkStmt->bindParam(':id', $this->id);
      $checkStmt->execute();

      // If no quotes found with the provided ID, return false immediately
      if ($checkStmt->fetchColumn() == 0) {
          return false;
      }
      
      // update query
      $query = 'UPDATE ' . 
          $this->table . ' 
      SET 
        quote = :quote, 
        author_id = :author_id,
        category_id = :category_id
      WHERE
       id = :id';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->id = htmlspecialchars(strip_tags($this->id));
      $this->quote = htmlspecialchars(strip_tags($this->quote));
      $this->author_id = htmlspecialchars(strip_tags($this->author_id));
      $this->category_id = htmlspecialchars(strip_tags($this->category_id));
      

      // Bind data
      $stmt->bindParam(':id', $this->id);
      $stmt->bindParam(':quote', $this->quote);
      $stmt->bindParam(':author_id', $this->author_id);
      $stmt->bindParam(':category_id', $this->category_id);

      //Execute statment
      if($stmt->execute()) {
          return true;
      } else {
          return false;
      }
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
      if($stmt->rowCount() > 0){
        return true;
      }
    }

    return false;
        
  }

    //Check if Author exsists
    public function authorExists($author_id) {
        $query = "SELECT COUNT(*) FROM authors WHERE id = :author_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':author_id', $author_id);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    // Check if category exists
    public function categoryExists($category_id) {
        $query = "SELECT COUNT(*) FROM categories WHERE id = :category_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }  
}
