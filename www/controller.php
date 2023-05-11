<?php
// Récupération des Models
require_once __DIR__ . "/models/Beers.php";
require_once __DIR__ . "/models/Ingredients.php";
// Récupération des constantes d'accès pour la base de données
require_once "./config.php";
// Récuparation des fonctions check Body
require_once './logic/checkBodyBeer.php';

// Récupère les trycatchs des ingrédients 
require_once "./logic/checkBodyIngredient.php";
//récupère le chemin appelé
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

//Choisir le controller a appelé en fonction du chemin
if (preg_match('#^/beers#', $uri)) {
  $res = manageBeers();
} elseif (preg_match('/^\/beers\/\d+\/ingredients\/\d+$/', $uri)) {
  $res = manageBeers();
} else {
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
  $queryName = isset($query['name']) ? $query['name'] : '';
  $queryType = isset($query['type']) ? $query['type'] : '';
  $queryPerPage = isset($query['per_page']) ? $query['per_page'] : '';
  $queryPage = isset($query['page']) ? $query['page'] : '';
  switch ($method) {
    case 'GET':
      if ($queryName) {
        $beerData = $beer->readBeerName($queryName);
        $beerList = [];
        foreach ($beerData as $beer) {
          $beerId = $beer->beer_id;
          if (!isset($beerList[$beerId])) {
            $beerList[$beerId] = [
              "id" => $beer->beer_id,
              "name" => $beer->name,
              "tagline" => $beer->tagline,
              "first_brewed" => $beer->first_brewed,
              "description" => $beer->description,
              "image_url" => $beer->image_url,
              "ingredients" => [],
              "brewers_tips" => $beer->brewers_tips,
              "contributed_by" => $beer->contributed_by,
              "food_pairing" => $beer->food_pairing,
              "food_pairing2" => $beer->food_pairing2,
              "food_pairing3" => $beer->food_pairing3
            ];
          }
          $beerList[$beerId]['ingredients'][] = [
            "id" => $beer->ingredient_id,
            "name" => $beer->name_ing,
            "type" => $beer->type,
            "amount_value" => $beer->amount_value,
            "amount_unit" => $beer->amount_unit,
            "amount_add" => $beer->amount_add,
            "amount_attribute" => $beer->amount_attribute,

          ];
        }
        return $beerList;
      }
      elseif ($queryType) {
        $beerData = $beer->readBeerType($queryType);
        $beerList = [];
        foreach ($beerData as $beer) {
          $beerId = $beer->beer_id;
          if (!isset($beerList[$beerId])) {
            $beerList[$beerId] = [
              "id" => $beer->beer_id,
              "name" => $beer->name,
              "tagline" => $beer->tagline,
              "first_brewed" => $beer->first_brewed,
              "description" => $beer->description,
              "image_url" => $beer->image_url,
              "ingredients" => [],
              "brewers_tips" => $beer->brewers_tips,
              "contributed_by" => $beer->contributed_by,
              "food_pairing" => $beer->food_pairing,
              "food_pairing2" => $beer->food_pairing2,
              "food_pairing3" => $beer->food_pairing3
            ];
          }
          $beerList[$beerId]['ingredients'][] = [
            "id" => $beer->ingredient_id,
            "name" => $beer->name_ing,
            "type" => $beer->type,
            "amount_value" => $beer->amount_value,
            "amount_unit" => $beer->amount_unit,
            "amount_add" => $beer->amount_add,
            "amount_attribute" => $beer->amount_attribute,

          ];
        }

        return $beerList;
      }
      elseif($id){
        $beerData = $beer->readBeer($id);
        if(count($beerData) == 1){
          return $beerData;
        }
        else{

          $beerList = [];
          foreach ($beerData as $beer) {
            $beerId = $beer->beer_id;
            if (!isset($beerList[$beerId])) {
              $beerList[$beerId] = [
                "id" => $beer->beer_id,
                "name" => $beer->name,
                "tagline" => $beer->tagline,
                "first_brewed" => $beer->first_brewed,
                "description" => $beer->description,
                "image_url" => $beer->image_url,
                "ingredients" => [],
                "brewers_tips" => $beer->brewers_tips,
                "contributed_by" => $beer->contributed_by,
                "food_pairing" => $beer->food_pairing,
                "food_pairing2" => $beer->food_pairing2,
                "food_pairing3" => $beer->food_pairing3
              ];
            }
            $beerList[$beerId]['ingredients'][] = [
              "id" => $beer->ingredient_id,
              "name" => $beer->name_ing,
              "type" => $beer->type,
              "amount_value" => $beer->amount_value,
              "amount_unit" => $beer->amount_unit,
              "amount_add" => $beer->amount_add,
              "amount_attribute" => $beer->amount_attribute,
              
            ];
          }
          return $beerList;
        }
      } else {
        if ($queryPerPage) {
          $queryLimit = $queryPerPage;
          if ($queryPage) {
            $queryOffset = $queryPage;
          } else {
            $queryOffset = 0;
          }
        } else {
          $queryLimit = 50;
          $queryOffset = 0;
        }
        $beerData = $beer->searchBeers($queryLimit, $queryOffset);
        $beerList = [];
        foreach ($beerData as $beer) {
          $beerId = $beer->beer_id;
          if (!isset($beerList[$beerId])) {
            $beerList[$beerId] = [
              "id" => $beer->beer_id,
              "name" => $beer->name,
              "tagline" => $beer->tagline,
              "first_brewed" => $beer->first_brewed,
              "description" => $beer->description,
              "image_url" => $beer->image_url,
              "ingredients" => [],
              "brewers_tips" => $beer->brewers_tips,
              "contributed_by" => $beer->contributed_by,
              "food_pairing" => $beer->food_pairing,
              "food_pairing2" => $beer->food_pairing2,
              "food_pairing3" => $beer->food_pairing3
            ];
          }
          $beerList[$beerId]['ingredients'][] = [
            "id" => $beer->ingredient_id,
            "name" => $beer->name_ing,
            "type" => $beer->type,
            "amount_value" => $beer->amount_value,
            "amount_unit" => $beer->amount_unit,
            "amount_add" => $beer->amount_add,
            "amount_attribute" => $beer->amount_attribute,

          ];
        }

        return $beerList;
      }
      break;
    case 'POST':
      try {
        if (!isset($matches[1]) && !isset($matches[2])) {
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
        } else {
          $beer_id = $matches[1];
          $ingredient_id = $matches[2];
          $resultat = $beer->addIngredient($beer_id, $ingredient_id);
          return $resultat;
        }
      } catch (Error $e) {
        throw $e;
      }
      break;
    case 'PUT':
    case 'PATCH':
      try {
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
 * @return tableau d'ingredients
 */
function manageIngredients()
{
  $ingredient = new Ingredients();
  $method = $_SERVER['REQUEST_METHOD'];
  $body = json_decode(file_get_contents('php://input'), true);
  parse_str($_SERVER['QUERY_STRING'], $query);
  $queryPerPage = isset($query['per_page']) ? $query['per_page'] : '';
  $queryPage = isset($query['page']) ? $query['page'] : '';
  // Récupération des variables.
  $id = isset($query['id']) ? $query['id'] : '';
  switch ($method) {
    case 'GET':
      try {
        if ($id) {
          $resultat = $ingredient->readIngredient($id);
          return $resultat;
        } else {
          if($queryPerPage){
            $limit = $queryPerPage;
            if($queryPage){
              $offset = $queryPage;
            }
            else{
              $offset = 0;
            }
          } else {
            $limit = 50;
            $offset = 0;
          }
          $resultat = $ingredient->searchIngredients($limit, $offset);
          return $resultat;
        }
      } catch (Error $e) {
        throw $e;
      }
      break;
    case 'DELETE':
      $resultat = $ingredient->deleteIngredient($id);
      return $resultat;
      break;
    case 'POST':
      try {
        $checkOk = checkBodyIngredient($body);
        $keys = array_keys($checkOk);
        $valueToInsert = [];
        foreach ($keys as $key) {
          if (in_array($key, ['type', 'name_ing', 'amount_value', 'amount_unit', 'amount_add', 'amount_attribute'])) {
            $valueToInsert[$key] = $checkOk[$key];
          }
        }
        $resultat = $ingredient->createIngredient($valueToInsert);
        return $resultat;
      } catch (Error $e) {
        die($e);
      }
      break;
    case 'PATCH':
    case 'PUT':
      try {
        $body = json_decode(file_get_contents('php://input'), true);
        $checkOk = checkBodyIngredient($body);
        $keys = array_keys($body);
        $valueToInsert = [];
        foreach ($keys as $key) {
          if (in_array($key, ['type', 'name_ing', 'amount_value', 'amount_unit', 'amount_add', 'amount_attribute'])) {
            $valueToInsert[$key] = $body[$key];
          }
        }
        $resultat = $ingredient->updateIngredient($valueToInsert, $id);
        return $resultat;
        break;
      } catch (Error $e) {
        throw ($e);
      }
      break;
  }
}
