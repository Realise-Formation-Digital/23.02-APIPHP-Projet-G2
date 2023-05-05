<?php


class Beers{
    private $connection = null;

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

    public function searchBeers() {
    try {
      $stmt = $this->pdo->prepare("SELECT * FROM beers");
      $stmt->execute();
      $clients = $stmt->fetchAll(PDO::FETCH_OBJ);
      return $beers;
    } catch(Exception $e) {
      throw $e;
    }
  }

    public function createBeer(){}

    public function readBeer(){}

    public function updateBeer(){}

    public function deleteBeer(){}

}