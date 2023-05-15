<?php

/**
 * deserialized
 *
 * @param  mixed $beerData
 * @return array
 */
function deserialized($beerData){
  try{

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
    
    $beersTab = [];
    foreach($beerList as $b) {
      $beersTab[] = $b;
    }
    return $beersTab;
  }
  catch(Exception $e){
    throw $e;
  }
}