<?php


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

  public function searchBeers()
  {
  }

  /**
   * createBeer
   *
   * @param  mixed $array tableau recuperer du controller
   * 
   */
  public function createBeer($array)
  {
    try {
      //recuperer chaque valeur
      $tab = [];
      foreach ($array as $ar) {
        array_push($tab, $ar);
      }

      //recuperer la food_pairing
      $tabFood = [];
      foreach ($tab[5] as $t) {
        array_push($tabFood, $t);
      }

      //implode — Rassemble les éléments d'un tableau en une chaîne
      //Les cles du tableau sont les noms de colonnes
      $keys = implode(", ", array_keys($array));

      $sql = "INSERT INTO beers ($keys,food_pairing2,food_pairing3) VALUES (?,?,?,?,?,?,?,?,?,?)";
      $stmt = $this->connection->prepare($sql);
      $stmt->execute(array($tab[0], $tab[1], $tab[2], $tab[3], $tab[4], $tabFood[0], $tab[6], $tab[7], $tabFood[1], $tabFood[2]));
      $id = $this->connection->lastInsertId();
      return $id;
      // return $this->read($id);
    } catch (Exception $e) {
      throw $e;
    }
  }

  public function readBeer()
  {
  }

  public function updateBeer($array, $id)
  {
    try {
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

      //implode — Rassemble les éléments d'un tableau en une chaîne
      //Les cles du tableau sont les noms de colonnes
      $keys = implode(", ", array_keys($array));

      $sql = "UPDATE clients SET $keys,food_pairing2=?,food_pairing3=? WHERE id=?";
      $stmt = $this->connection->prepare($sql);
      $stmt->execute(array($tab[0], $tab[1], $tab[2], $tab[3], $tab[4], $tabFood[0], $tab[6], $tab[7], $tabFood[1], $tabFood[2], $id));
      return $id;
    } catch (Exception $e) {
      throw $e;
    }
  }

  public function deleteBeer()
  {
  }
}
