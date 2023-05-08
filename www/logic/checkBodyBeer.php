<?php

/**
 * checkBodyBeer
 *Sert à controller les valeurs entrer dans le body
 * @param  mixed $body
 * @return array body
 */
function checkBodyBeer($body){
    if (!$body) {
        throw new Exception("Aucune donnée n'a été transmise dans le formulaire");
      }
    if(!$body['name']){
        throw new Exception("Il n'y a pas de nom!!!");
    }
    if(strlen($body['name']) > 25){
        throw new Exception("Le nom est trop long");
    }
    if(!$body['tagline']){
        throw new Exception("Il n'y a pas de tagline!!!");
    }
    if(strlen($body['name']) > 50){
        throw new Exception("La tagline est trop longue");
    }
    if(!$body['first_brewed']){
        throw new Exception("Il n'y a pas de date de brassage");
    }
    if(strlen($body['first_brewed']) > 10){
        throw new Exception("La date est trop longue");
    }
    if(!$body['description']){
        throw new Exception("Il n'y a pas de description");
    }
    if(strlen($body['description']) > 250){
        throw new Exception("La description est trop longue");
    }
    if(!$body['image_url']){
        throw new Exception("Il n'y a pas d'image");
    }
    if(strlen($body['image_url']) > 500){
        throw new Exception("Le chemin de l'image est trop longue");
    }
    if(!$body['brewers_tips']){
        throw new Exception("Il n'y a pas de conseil du brasseur");
    }
    if(strlen($body['brewers_tips']) > 500){
        throw new Exception("Les conseils sont trop longs");
    }
    if(!$body['contributed_by']){
        throw new Exception("Il n'y a pas de contribution.");
    }
    if(strlen($body['image_url']) > 50){
        throw new Exception("Il y a trop de nom");
    }
    if(count($body['food_pairing']) !== 3){
        throw new Exception("Il n'y a pas assez ou trop d'association à la nourriture, il en faut 3");
    }
    if(strlen($body['food_pairing'][0]) > 50){
        throw new Exception("Maximum 50 caractères pour le food_pairing");
    }
    if(strlen($body['food_pairing'][1]) > 50){
        throw new Exception("Maximum 50 caractères pour le food_pairing");
    }
    if(strlen($body['food_pairing'][2]) > 50){
        throw new Exception("Maximum 50 caractères pour le food_pairing");
    }

    return $body;
}

?>