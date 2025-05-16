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

    while($nombre > 0){
        $chiffres[] = $nombre % 10;
        $nombre = intval($nombre/10);
    }

    return array_reverse($chiffres);
}

// 1.c. Algorithme pour inverser un nombre entier

function inverseNombre($nombre){
    $resultat = 0;
    $nombreCopie = $nombre;
    
    $nbChiffres = 1;
    while($nombreCopie >= 10){
        $nombreCopie = intval($nombreCopie/10);
        $nbChiffres++;
    }

    while($nombre > 0){
        $chiffre = $nombre % 10;
        $resultat += $chiffre * pow(10, $nbChiffres - 1);
        $nombre = intval($nombre/10);
        $nbChiffres--;
    }

    return $resultat;
}

?>