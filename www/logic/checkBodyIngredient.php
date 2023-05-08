<?php

function checkBodyIngredient () {
              //body
              if (!$body) {
                throw new Exception("Aucune donnée n'a été transmise dans le formulaire");}
              }

              //Type
              if (!isset($body['type'])) {
                throw new Exception("Aucun type n'a été spécifié");
              }
              if (($body['type'] !=='malt'  || $body['type'] !=='hops')) {
              throw new Exception("Seuls malt ou hops sont autorisés");
              }

              //Name
              if (!isset($body['name'])) {
                throw new Exception("Aucun mot n'a été spécifié");
              }
              if (strlen($body['name']) > 50) {
                throw new Exception("Le nom ne peut pas contenir plus de 50 caractères");
              }

              //Amount value
              if (!isset($body['amount_unit'])) {
                throw new Exception("Aucune unité n'a été spécifiée");
              }
              if (!is_float($body['amount_value'])) {
                throw new Exception("La valeur doit êtres un nombres");
              }
              if (filter_var($body['amount_value'], FILTER_VALIDATE_FLOAT, array('options' => array('min_range' => 1, 'max_range' => 255)))) {
                throw new Exception('Il faut entre 1 et 255 caractères dans la valeur');
              }

                //Amount unit
              if (!isset($body['amount_unit'])) {
                throw new Exception("l'Veuillez saisir une unité");
              }
              if (strlen($body['amount_unit']) > 15) {
                throw new Exception("l'Unité ne dois pas dépasser 15 caractères");
              }

              //Amount add
              if (strlen ($body['amount_add']) > 15) {
                throw new Exception("Ne dois pas dépasser 15 caractères");
              }

              //Amount attribute
              if (strlen ($body['amount_attribute']) > 15){
                throw new Exception("Ne dois pas dépasser 15 caractères");
              }
