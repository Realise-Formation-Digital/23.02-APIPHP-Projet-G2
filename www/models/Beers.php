<?php

require_once("./config.php");

class Beers{
    private $connection = null;

    private $pdo;

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
          $stmt = $this->pdo->prepare("SELECT * FROM beers WHERE id=?");
          $stmt->execute([$id]);
          $client = $stmt->fetch(PDO::FETCH_OBJ);
          return $client;
        } catch(Exception $e) {
          throw $e;
        }
    }

    public function updateBeer(){}

    public function deleteBeer(){}

}