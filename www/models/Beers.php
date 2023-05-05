<?php

require_once("./config.php");

class Beers{
    private $connection;

    /**
     * Constructor - Connect to the database.
     */
    public function __construct()
    {
      try {
        // Connect to the database.
        $this->connection = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE_NAME, DB_USERNAME, DB_PASSWORD);
      } catch(PDOException $e) {
        // Send an error because it could not connect to the database.
        throw new Exception($e->getMessage());
      }      
    }

    public function searchBeers(){}
    

    public function createBeer(){}

    public function readBeer($id){
          try {
          $stmt = $this->connection->prepare("SELECT * FROM beers WHERE id=?");
          $stmt->execute([$id]);
          $beer = $stmt->fetch(PDO::FETCH_OBJ);
          return $beer;
        } catch(Exception $e) {
          throw $e;
        }
    }

    public function updateBeer(){}

    public function deleteBeer(){}

}