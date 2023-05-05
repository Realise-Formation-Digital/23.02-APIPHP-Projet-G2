<?php
// Récupération des Models
require_once __DIR__ . "/models/Beers.php";
require_once __DIR__ . "/models/Ingredients.php";
// Récupération des constantes d'accès pour la base de données
require_once "./config.php";

//récupère le chemin appelé
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

//Choisir le controller a appelé en fonction du chemin
//$uri == "/beers" ? $res = manageBeers() : $res = manageIngredients();



if (preg_match('#^/beers#', $uri)) {
    $res = manageBeers();
} else {
    $res = manageIngredients();
}

var_dump('uri : ' . $uri);
//$body = json_decode(file_get_contents('php://input'));
var_dump($_SERVER['QUERY_STRING']);

parse_str($_SERVER['QUERY_STRING'], $query);



/**
 * manageBeers
 *
 * @return void
 */
function manageBeers()
{
    $beer = new Beers();
    $method = $_SERVER['REQUEST_METHOD'];
    $id = isset($query['id']) ? $query['id'] : '';
    var_dump('id : ' . $id);


    switch ($method) {
        case 'GET':
            if ($id) {
                $beer->readBeer($id);
            }
    }
}
/**
 * manageIngredients
 *
 * @return void
 */
function manageIngredients()
{
    // var_dump('ingredients');
}
