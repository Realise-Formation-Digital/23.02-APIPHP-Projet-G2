<?php
// Récupération des Models
require_once __DIR__ . "/models/Beers.php";
require_once __DIR__ . "/models/Ingredients.php";
// Récupération des constantes d'accès pour la base de données
require_once "./config.php";
// Récuparation des fonctions check Body
require_once './logic/checkBodyBeer.php';

//récupère le chemin appelé
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

//Choisir le controller a appelé en fonction du chemin
if (preg_match('#^/beers#', $uri)) {
  $res = manageBeers();
} elseif(preg_match('/^\/beers\/\d+\/ingredients\/\d+$/', $uri)) {
  $res = manageBeers();
}
else{
  $res = manageIngredients();
}
header('Content-Type:application/json;charset=utf-8');

echo (json_encode($res));

/**
 * manageBeers
 *
 * @return array
 */
function manageBeers()
{
  $beer = new Beers();
  $method = $_SERVER['REQUEST_METHOD'];
  parse_str($_SERVER['QUERY_STRING'], $query);
  $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  $body = json_decode(file_get_contents('php://input'), true);
  $beer_id = "";
  $ingredient_id = "";
  preg_match('/^\/beers\/(\d+)\/ingredients\/(\d+)$/', $uri, $matches);  
  // Récupération des variables.
  $id = isset($query['id']) ? $query['id'] : '';
  switch ($method) {
    case 'GET':
      if ($id) {
        $resultat = $beer->readBeer($id);
        return $resultat;
      } else {
        $resultat = $beer->searchBeers();
        return $resultat;
      }
      break;
    case 'POST':
      try {
          if(!isset($matches[1]) && !isset($matches[2])){
          //methode permettant de controller les valeurs
          $bodyOk = checkBodyBeer($body);
          //creer le tableau avec les bonnes valeurs à insérer en fonction ds clés.
          $keys = array_keys($bodyOk);
         
          $valueToInsert = [];
          foreach ($keys as $key) {
            if (in_array($key, ['name', 'tagline', 'first_brewed', 'description', 'image_url', 'brewers_tips', 'contributed_by', 'food_pairing'])) {
              $valueToInsert[$key] = $bodyOk[$key];
            }
          }
            $resultat = $beer->createBeer($valueToInsert);
            return $resultat;
        }
        else
        {
          $beer_id = $matches[1];
          $ingredient_id = $matches[2];
          $resultat = $beer->addIngredient($beer_id,$ingredient_id);
          return $resultat;
        }
      } 
      catch (Error $e)
          {
            throw $e;
          }
      break;
    case 'PUT':
    case 'PATCH':
      try {
        //methode permettant de controller les valeurs
        $bodyOk = checkBodyBeer($body);
        //creer le tableau avec les bonnes valeurs à insérer en fonction ds clés.
        $keys = array_keys($bodyOk);
        $valueToInsert = [];
        foreach ($keys as $key) {
          if (in_array($key, ['name', 'tagline', 'first_brewed', 'description', 'image_url', 'brewers_tips', 'contributed_by', 'food_pairing'])) {
            $valueToInsert[$key] = $body[$key];
          }
        }
        $resultat = $beer->updateBeer($valueToInsert, $id);
        return $resultat;
      } catch (Error $e) {
        throw ($e);
      }
      break;
    case 'DELETE':
      $resultat = $beer->deleteBeer($id);
      return $resultat;
      break;
  }
}

/**
 * manageIngredients
 *
 * @return void
 */
function manageIngredients()
{
  $ingredient = new Ingredients();
  $method = $_SERVER['REQUEST_METHOD'];
  $body = json_decode(file_get_contents('php://input'), true);
  parse_str($_SERVER['QUERY_STRING'], $query);
  // Récupération des variables.
  $id = isset($query['id']) ? $query['id'] : '';
  switch ($method) {
    case 'GET':
      if ($id) {
        $resultat = $ingredient->readIngredient($id);
        return $resultat;
      } else {
        $resultat = $ingredient->searchIngredients();
        return $resultat;
      }
      break;
    case 'DELETE':
      $resultat = $ingredient->deleteIngredient($id);
      return $resultat;
      break;
    case 'POST':
      try {
        $type = isset($body['type']) ? $body['type'] : '';
        $name = isset($body['name']) ? $body['name'] : '';
        $amount_value = isset($body['amount_value']) ? $body['amount_value'] : '';
        $amount_unit = isset($body['amount_unit']) ? $body['amount_unit'] : '';
        $amount_add = isset($body['amount_add']) ? $body['amount_add'] : '';
        $amount_attribute = isset($body['amount_attribute']) ? $body['amount_attribute'] : '';
        $resultat = $ingredient->createIngredient($type, $name, $amount_value, $amount_unit, $amount_add, $amount_attribute);
        return $resultat;
        break;
      } catch (Error $e) {
        die($e);
      }
      break;
    case 'PATCH':
    case 'PUT':
      try {

        $keys = array_keys($body);
        $valueToInsert = [];
        foreach ($keys as $key) {
          if (in_array($key, ['type', 'name', 'amount_value', 'amount_unit', 'amount_add', 'amount_attribute'])) {
            $valueToInsert[$key] = $body[$key];
          }
        }
        $resultat = $ingredient->updateIngredient($valueToInsert, $id);
        var_dump($resultat);
        return $resultat;
        break;
      } catch (Error $e) {
        die($e);
      }
  }
}
