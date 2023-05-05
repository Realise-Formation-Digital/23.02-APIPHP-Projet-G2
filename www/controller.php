<?php
// Récupération des Models
require_once __DIR__ . "/models/Beers.php";
require_once __DIR__ . "/models/Ingredients.php";
 // Récupération des constantes d'accès pour la base de données
 require_once "./config.php";

//récupère le chemin appelé
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

//Choisir le controller a appelé en fonction du chemin
$uri === "/beers" ? manageBeers() : manageIngredients();

$body = json_decode(file_get_contents('php://input'));




/**
 * manageBeers
 *
 * @return void
 */
function manageBeers(){
    $method = $_SERVER['REQUEST_METHOD'];
    $id = isset($query['id']) ? $query['id'] : '';
    $beers = new Beers;
    
    
    switch($method) {
        case 'GET':
          if ($id) {
            $beers->read($id);
          }
    var_dump($beers);
}
}
/**
 * manageIngredients
 *
 * @return void
 */
function manageIngredients(){
   // var_dump('ingredients');
}

?>