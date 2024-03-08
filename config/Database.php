<?php 

//XAMPP connection
  // class Database {
  //   // DB Params
  //   private $host = 'localhost';
  //   private $db_name = 'myblog';
  //   private $username = 'root';
  //   private $password = '';
  //   private $conn;

  //   // DB Connect
  //   public function connect() {
  //     $this->conn = null;

  //     try { 
  //       $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
  //       $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //     } catch(PDOException $e) {
  //       echo 'Connection Error: ' . $e->getMessage();
  //     }

  //     return $this->conn;
  //   }
  // }

  //-------------------------------------------------------------------------------------

  // //Postgres connection

  // class Database{
  //   private $host = 'dpg-cnbqtmta73kc73ath0vg-a.oregon-postgres.render.com';
  //   private $port = '5432';
  //   private $db_name = 'myblog_hq0w';
  //   private $username = 'myblog_hq0w_user';
  //   private $password = 'PGB1XTk9YqEZp4GWxdHvoMtqpOJ1r0yz';
  //   private $conn;

  //   public function connect(){
  //     $this->conn = null;
  //     $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->db_name};";

  //     try{
  //         $this->conn = new PDO($dsn, $this->username, $this->password);
  //         $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          
  //     } catch(PDOException $e){
  //       echo 'Connection Error: ' . $e->getMessage();
  //     }
  //     return $this->conn;
  //   }
  // }

//--------------------------------------------------------------------------------------------

//render.com connection

// include_once '../.htaccess';

  class Database{
  // DB Params
  private  $host;
  private $port;
  private $db_name;
  private $username;
  private $password;
    private $conn;

    public function __construct(){
      $this->username = getenv('USERNAME');
      $this->password = getenv('PASSWORD');
      $this->db_name = getenv('DB_NAME');
      $this->host = getenv('HOST');
      $this->port = getenv('PORT');
    }

    public function connect(){
      if($this->conn){
        return $this->conn;
      }else{
        $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->db_name};";

        try{
          $this->conn = new PDO($dsn, $this->username, $this->password);
          $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          return $this->conn;
        } catch(PDOException $e){
          echo 'Connection Error: ' . $e->getMessage();
        }
      }
    }
  }