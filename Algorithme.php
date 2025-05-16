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


// Tests et exemples d'utilisation
echo "=== Tests des algorithmes ===\n\n";

// Test 1.a - Prix HT
echo "1.a. Calcul du prix HT:\n";
$prixTTC = 118;
$prixHT = calculePrixHT($prixTTC);
echo "Prix TTC: $prixTTC € → Prix HT: $prixHT €\n\n";

// Test 1.b - Décomposition
echo "1.b. Décomposition d'un nombre:\n";
$nombre = 1080;
$chiffres = decomposeNombre($nombre);
echo "Nombre: $nombre → Chiffres: " . implode(", ", $chiffres) . "\n";

$nombre2 = 5432;
$chiffres2 = decomposeNombre($nombre2);
echo "Nombre: $nombre2 → Chiffres: " . implode(", ", $chiffres2) . "\n\n";

// Test 1.c - Inversion
echo "1.c. Inversion d'un nombre:\n";
$nombre3 = 2030;
$inverse = inverseNombre($nombre3);
echo "Nombre: $nombre3 → Inverse: $inverse\n";

$nombre4 = 12345;
$inverse2 = inverseNombre($nombre4);
echo "Nombre: $nombre4 → Inverse: $inverse2\n";

?>