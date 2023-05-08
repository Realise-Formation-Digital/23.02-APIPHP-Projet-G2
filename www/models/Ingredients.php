<?php

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

    public function updateIngredient ($array, $id)
  {
    try {
      //recuperer chaque valeur
      $tab = [];
      foreach ($array as $ar) {
        array_push($tab, $ar);
      }

     

      $sql = "UPDATE ingredients SET name=?,tagline=?,first_brewed=?,description=?,image_url=?,brewers_tips=?,contributed_by=?,food_pairing=?,food_pairing2=?,food_pairing3=? WHERE id=?";
      $stmt = $this->connection->prepare($sql);
      $stmt->execute(array($tab[0], $tab[1], $tab[2], $tab[3], $tab[4], $tab[6], $tab[7], $tabFood[0], $tabFood[1], $tabFood[2], $id));
      return $this->readBeer($id);
    } catch (Exception $e) {
      throw $e;
    }
  }

    public function deleteIngredient(){}

}