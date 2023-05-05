<?php
// Récupération des Models
require_once __DIR__ . "/models/Beers.php";
require_once __DIR__ . "/models/Ingredients.php";
 // Récupération des constantes d'accès pour la base de données
 require_once "./config.php";



//récupère le chemin appelé
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

//Choisir le controller a appelé en fonction du chemin
$uri === "/beers" ? $res = manageBeers() : $res = manageIngredients();


/**
 * manageBeers
 *
 * @return array
 */
function manageBeers(){
    $beer = new Beers();
    $method = $_SERVER['REQUEST_METHOD'];
    $body = json_decode(file_get_contents('php://input'), true);
    
    switch($method) {
        case 'POST':
            try {
            //controler les entrées
            if (!$body) {
                throw new Exception("Aucune donnée n'a été transmise dans le formulaire");
              }
              if (!isset($body['name'])) {
                throw new Exception("Aucun nom n'a été spécifié");
              }
              if (!isset($body['tagline'])) {
                throw new Exception("Aucune tag line n'a été spécifié");
              }
              if (!isset($body['first_brewed'])) {
                throw new Exception("Aucun date de brassage n'a été spécifié");
              }
              if (!isset($body['description'])) {
                throw new Exception("Aucune description n'a été spécifié");
              }
              if (!isset($body['image_url'])) {
                throw new Exception("Aucun chemin d'image n'a été spécifié");
              }
              if (!isset($body['brewers_tips'])) {
                throw new Exception("Aucune façon de brasser n'a été spécifié");
              }
              if (!isset($body['contributed_by'])) {
                throw new Exception("Aucun(e) contributeur(se) n'a été spécifié");
              }
              if (!isset($body['food_pairing'])) {
                throw new Exception("Aucune association à de la nourriture n'a été spécifié");
              }

            $keys = array_keys($body);
            $valueToInsert = [];
            foreach($keys as $key) {
                if(in_array($key, ['name', 'tagline', 'first_brewed', 'description', 'image_url','brewers_tips','contributed_by','food_pairing'])){
                    $valueToInsert[$key] = $body[$key];
                }
            }
            $resultat = $beer->createBeer($valueToInsert);
            return $resultat;
            break;
        }
        catch (Error $e) 
        {
          die($e);
        }
      case 'PUT':
      case 'PATCH':
        try{


        }
        catch(Error $e){
          die($e);
        }
    }
}

/**
 * manageIngredients
 *
 * @return void
 */
function manageIngredients(){
    var_dump('ingredients');
}

?>