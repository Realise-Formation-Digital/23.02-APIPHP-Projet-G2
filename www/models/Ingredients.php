<?php

require_once("./config.php");

class Ingredients{
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

    public function searchIngredients(){
      try {
        $stmt = $this->connection->prepare("SELECT * FROM ingredients");
        $stmt->execute();
        $beers = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $beers;
      } catch(Exception $e) {
        throw $e;
      }
    }

    public function createIngredient($array){
      try{
        //recuperer chaque valeur
        $tab = [];
        foreach ($array as $ar) {
          array_push($tab, $ar);
        }
        $tabFood=[];
        //recuperer vla food_pairing
        foreach($tab[5] as $t){
          array_push($tabFood,$t);
        }
  
        //implode — Rassemble les éléments d'un tableau en une chaîne
        //Les cles du tableau sont les noms de colonnes
        $keys = implode(", ", array_keys($array));
        $sql = "INSERT INTO ingredients ($keys) VALUES (?,?,?,?,?,?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(array());
        $id = $this->connection->lastInsertId();
        return $this->readIngredient($id);
      } catch (Exception $e) {
        throw $e;
      }
    }

    public function readIngredient($id){
      try {
        $stmt = $this->connection->prepare("SELECT * FROM ingredients WHERE id=?");
        $stmt->execute([$id]);
        $beer = $stmt->fetch(PDO::FETCH_OBJ);
        return $beer;
      } catch(Exception $e) {
        throw $e;
      }
    }

    public function updateIngredient(){}

    public function deleteIngredient(){}

}