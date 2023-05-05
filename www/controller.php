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
 * @return void
 */
function manageBeers(){
    $beer = new Beers ();
}

/**
 * manageIngredients
 *
 * @return void
 */
function manageIngredients(){
    var_dump('ingredients');
}


if ($uri) {}
else {
    $resultat = $beer->search();
}
?>