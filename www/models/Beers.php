<?php

require_once("./config.php");

class Beers
{
  private $connection;

  /**
   * Constructor - Connect to the database.
   */
  public function __construct()
  {
    try {
      // Connect to the database.
      $this->connection = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE_NAME, DB_USERNAME, DB_PASSWORD);
    } catch (PDOException $e) {
      // Send an error because it could not connect to the database.
      throw new Exception($e->getMessage());
    }
  }
    
    /**
     * searchBeers
     *
     * @return tableau de bière
     */
    public function searchBeers($limit, $offset) {
      try {
        $offsetCalculation = ($offset-1)*$limit;
        $stmt = $this->connection->prepare("SELECT * FROM beers as b
                                            LEFT JOIN beer_ingredient ON b.id = beer_ingredient.beer_id
                                            INNER JOIN ingredients as i ON beer_ingredient.ingredient_id = i.id
                                            ORDER BY b.id
                                            LIMIT $limit
                                            OFFSET $offsetCalculation");
        $stmt->execute();
        $beer = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $beer;
      } catch(Exception $e) {
        throw $e;
        };
  }

  /**
   * readBeer
   *
   * @param  mixed $id
   * @return une biere
   */
  public function readBeer($id) {
    try {
      $stmt = $this->connection->prepare("SELECT * FROM beers as b
                                          LEFT JOIN beer_ingredient ON b.id = beer_ingredient.beer_id
                                          INNER JOIN ingredients as i ON beer_ingredient.ingredient_id = i.id
                                          WHERE b.id = :id");
      $stmt->execute(['id' => $id]);
      $beer = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!$beer){
        return ['message' => "La bière n'existe pas."];
      }else{
        return $beer;
      }
    } catch(Exception $e) {
      throw $e;
      };
    }

     /**
   * readBeerName
   *
   * @param  mixed $queryName (beerName)
   * @return une biere
   */
  public function readBeerName($queryName) {
    try {

      $queryNameSQL = '%'. $queryName . '%';
      $stmt = $this->connection->prepare('SELECT * FROM beers as b
                                          LEFT JOIN beer_ingredient ON b.id = beer_ingredient.beer_id
                                          INNER JOIN ingredients as i ON beer_ingredient.ingredient_id = i.id 
                                          WHERE b.name 
                                          LIKE :queryName');
      $stmt->bindParam(':queryName', $queryNameSQL);
      $stmt->execute();

      $beers = $stmt->fetchAll(PDO::FETCH_OBJ);
      return $beers;
    } catch(Exception $e) {
      throw $e;
      };
    }

    public function readBeerType($queryType) {
      try {
        
        $queryNameSQL = '%'. $queryType . '%';
        $stmt = $this->connection->prepare('SELECT * FROM beers as b
                                            INNER JOIN beer_ingredient ON b.id = beer_ingredient.beer_id
                                            INNER JOIN ingredients as i ON beer_ingredient.ingredient_id = i.id 
                                            WHERE i.type 
                                            LIKE :queryType');
        $stmt->bindParam(':queryType', $queryNameSQL);
        $stmt->execute();
  
        $beers = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $beers;
      } catch(Exception $e) {
        throw $e;
        };
      }
  

    /**
     * createBeer
     *
     * @param  mixed $array tableau recuperer du controller
     * retourne l'objet creer
     */
    public function createBeer($array){
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
      $sql = "INSERT INTO beers ($keys,food_pairing2,food_pairing3) VALUES (?,?,?,?,?,?,?,?,?,?)";
      $stmt = $this->connection->prepare($sql);
      $stmt->execute(array($tab[0],$tab[1],$tab[2],$tab[3],$tab[4],$tabFood[0],$tab[6],$tab[7],$tabFood[1],$tabFood[2]));
      $id = $this->connection->lastInsertId();
      return $id;
    } catch (Exception $e) {
      throw $e;
    }
  }
  
  /**
   * addIngredient
   *
   * @param  mixed $beer_id
   * @param  mixed $ingredient_id
   * @return le tableau d'association
   */
  public function addIngredient($beer_id, $ingredient_id){
    try{
      
      $sql = "INSERT INTO beer_ingredient (beer_id,ingredient_id) VALUES (?,?)";
      $stmt = $this->connection->prepare($sql);
      $stmt->execute(array($beer_id,$ingredient_id));
      return $this->readBeer($beer_id);
    } catch (Exception $e) {
      throw $e;
    }
  }
  
  /**
   * updateBeer
   *
   * @param  mixed $array
   * @param  mixed $id
   * @return array beer
   */
  public function updateBeer($array, $id)
  {
    try {
      var_dump($array);
      //recuperer chaque valeur
      $tab = [];
      foreach ($array as $ar) {
        array_push($tab, $ar);
      }
      
      //recuperer vla food_pairing
      $tabFood = [];
      foreach ($tab[5] as $t) {
        array_push($tabFood, $t);
      }
      
      var_dump($tab);
      var_dump($tabFood);
      $sql = "UPDATE beers SET name=?,tagline=?,first_brewed=?,description=?,image_url=?,brewers_tips=?,contributed_by=?,food_pairing=?,food_pairing2=?,food_pairing3=? WHERE id=?";
      $stmt = $this->connection->prepare($sql);
      $stmt->execute(array($array['name'],$array['tagline'],$array['first_brewed'],$array['description'],$array['image_url'],$array['brewers_tips'],$array['contributed_by'],$tabFood[0],$tabFood[1],$tabFood[2], $id));
      return $this->readBeer($id);
    } catch (Exception $e) {
      throw $e;
    }
  }

  public function deleteBeer($id)
  {
    try {
      $beer = $this->readBeer($id);
      $sql = "DELETE FROM beers WHERE id=?";
      $stmt = $this->connection->prepare($sql);
      $stmt->execute(array($id));
      return ["message" => "La bière " . $beer[0]->name . " a été correctement supprimé"];
    } catch(Exception $e) {
      throw $e;
    }
  }
}
