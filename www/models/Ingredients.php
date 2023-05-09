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
        //implode — Rassemble les éléments d'un tableau en une chaîne
        //Les cles du tableau sont les noms de colonnes
        $keys = implode(", ", array_keys($array));
        $sql = "INSERT INTO ingredients ($keys) VALUES (?,?,?,?,?,?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(array($array['type'], $array['name_ing'], $array['amount_value'], $array['amount_unit'], $array['amount_add'], $array['amount_attribute']));
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
        $ingredient = $stmt->fetch(PDO::FETCH_OBJ);
        return $ingredient;
      } catch(Exception $e) {
        throw $e;
      }
    }

    public function updateIngredient ($array, $id)
  {
    try {
      //recuperer chaque valeur
      $tab = [];
      foreach ($array as $ar) {
        array_push($tab, $ar);
      }
      $sql = "UPDATE ingredients SET type=?,name_ing=?,amount_value=?,amount_unit=?,amount_add=?, amount_attribute=? WHERE id=?";
      $stmt = $this->connection->prepare($sql);
      $stmt->execute(array($tab[0], $tab[1], $tab[2], $tab[3], $tab[4], $tab[5], $id));
      return $this->readIngredient($id);
    } catch (Exception $e) {
      throw $e;
    }
  }

    public function deleteIngredient($id){
      try {
        $ingredient = $this->readIngredient($id);
        $sql = "DELETE FROM ingredients WHERE id=?";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(array($id));
        return ['message' => "L'ingrédient $ingredient->name_ing a été correctement supprimé"];
      } catch(Exception $e) {
        throw $e;
      }
    }

}