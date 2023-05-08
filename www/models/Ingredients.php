<?php

require_once("./config.php");

class Ingredients{
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

    public function searchIngredients(){}

    public function createIngredient(){}

    public function readIngredient(){}

    public function updateIngredient(){}

    public function deleteIngredient(){
      try {
        $ingredient = $this->readIngredient($id);
        $sql = "DELETE FROM ingredients WHERE id=?";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(array($id));
        return ['message' => "L'ingrédient $ingredient->name a été correctement supprimé"];
      } catch(Exception $e) {
        throw $e;
      }
    }

}