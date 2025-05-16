<?php

//1.a. Algorithme pour calculer le prix HT à partir du prix TTC (TVA = 18%)

function calculePrixHT($prixTTC){
    $tauxTVA = 0.18; //18%
    $prixHT = $prixTTC / (1+ $tauxTVA);

    return round($prixHT, 2);
}


//1.b. Algorithme pour décomposer un nombre en ses chiffres (0-10000)

function decomposeNombre($nombre){
    $chiffres = array();

    if($nombre == 0){
        return array(0);
        
    }
}

?>