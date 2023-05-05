<?php
// Récupération des Models
require_once __DIR__ . "/models/Beers.php";
require_once __DIR__ . "/models/Ingredients.php";
 // Récupération des constantes d'accès pour la base de données
 require_once "./config.php";



//récupère le chemin appelé
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

//Choisir le controller a appelé en fonction du chemin
$uri === "/beers" ? $r = manageBeers() : $r = manageIngredients();

var_dump($r);

/**
 * manageBeers
 *
 * @return void
 */
function manageBeers(){
    $beer = new Beers();
    $method = $_SERVER['REQUEST_METHOD'];
    $body = json_decode(file_get_contents('php://input'), true);
    
    switch($method) {
        case 'POST':
            $keys = array_keys($body);
            $valueToInsert = [];
            foreach($keys as $key) {
                if(in_array($key, ['id','name', 'tagline', 'first_brewed', 'description', 'image_url','brewers_tips','contributed_by','food_pairing'])){
                    $valueToInsert[$key] = $body[$key];
                }
            }
            $resultat = $beer->createBeer($valueToInsert);
            return $resultat;
            break;
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