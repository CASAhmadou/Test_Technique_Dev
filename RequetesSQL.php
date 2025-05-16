<?php

//Structures des tables:
/**
    * categories(id, nom)

    * sous_categories(id, nom, categorie_id)

    * sous_sous_categories(id, nom, sous_categorie_id)

    * produits(id, nom, categorie_id, sous_categorie_id, sous_sous_categorie_id)
*/

// a. Requetes qui donne juste les catégories:

"SELECT * FROM categories";

// b. Requete qui donne juste les sous-categories ayant au moins un produit lié directement à elles:

" SELECT DISTINT sc.* FROM sous_categories sc INNER JOIN produits p ON sc.id = p.sous_categorie_id";

// c. Requête qui donne les produits liés à la catégorie dont l'id = 8, que ce soit directement ou via sous_catégorie ou sous_sous_catégorie:

"  SELECT DISTINCT p.* FROM produits p 
    LEFT JOIN sous_categories sc ON p.sous_categorie_id = sc.id 
    LEFT JOIN sous_sous_categories ssc ON p.sous_sous_categorie_id = ssc.id 
    LEFT JOIN sous_categories sc2 ON ssc.sous_categorie_id = sc2.id
    WHERE p.categorie_id = 8 OR sc.categorie_id = 8 OR sc2.categorie_id = 8
";

// d. Requête qui donne les produits appartenant à la même catégorie que celle liée à la sous-catégorie d'id 15:

" SELECT DISTINCT p.* FROM produits p 
    LEFT JOIN sous_categories sc ON p.sous_categorie_id = sc.id 
    LEFT JOIN sous_sous_categories ssc ON p.sous_sous_categorie_id = ssc.id 
    LEFT JOIN sous_categories sc2 ON ssc.sous_categorie_id = sc2.id 
    WHERE p.categorie_id = (SELECT categorie_id FROM sous_categories WHERE id = 15) 
    OR sc.categorie_id = (SELECT categorie_id FROM sous_categories WHERE id = 15) 
    OR sc2.categorie_id = (SELECT categorie_id FROM sous_categories WHERE id = 15)
";

// e. Requete qui donne les 3 catégories ayant le plus de produits liés, tous niveaux confondus, triées par ordre décroissant:

" WITH comptage_produits AS (
    -- Produits liés directement aux catégories
    SELECT c.id as categorie_id, c.nom as categorie_nom, COUNT(p.id) as nb_produits FROM categories c 
    LEFT JOIN produits p ON c.id = p.categorie_id GROUP BY c.id, c.nom 
    UNION ALL 

    -- Produits liés via sous-catégories
    SELECT sc.categorie_id as categorie_id, c.nom as categorie_nom, COUNT(p.id) as nb_produits FROM sous_categories sc 
    JOIN categories c ON sc.categorie_id = c.id 
    LEFT JOIN produits p ON sc.id = p.sous_categorie_id 
    GROUP BY sc.categorie_id, c.nom 
    UNION ALL

    -- Produits liés via sous-sous-catégories
    SELECT sc.categorie_id as categorie_id, c.nom as categorie_nom, COUNT(p.id) as nb_produits FROM sous_sous_categories ssc
    JOIN sous_categories sc ON ssc.sous_categorie_id = sc.id
    JOIN categories c ON sc.categorie_id = c.id
    LEFT JOIN produits p ON ssc.id = p.sous_sous_categorie_id
    GROUP BY sc.categorie_id, c.nom
 ) 
    SELECT categorie_id, categorie_nom, SUM(nb_produits) as total_produits FROM comptage_produits 
    GROUP BY categorie_id, categorie_nom 
    ORDER BY total_produits DESC LIMIT 3
 ";

 // f. Architecture de table unique pour toute la hiérarchie:

 " CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255) NOT NULL,
    parent_id INT DEFAULT NULL,
    niveau TINYINT NOT NULL, -- (1=catégorie, 2=sous_catégorie, 3=sous_sous_catégorie)
    chemin VARCHAR(500),
    FOREIGN KEY (parent_id) REFERENCES categories(id),
    CONSTRAINT chk_niveau CHECK (niveau IN (1, 2, 3)),
    CONSTRAINT chk_parent_niveau CHECK (
        (niveau = 1 AND parent_id IS NULL) OR 
        (niveau > 1 AND parent_id IS NOT NULL)
    )
)

-- Table des produits avec cette nouvelle structure
CREATE TABLE produits (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255) NOT NULL,
    categorie_id INT NOT NULL,
    FOREIGN KEY (categorie_id) REFERENCES categories(id),
    INDEX idx_categorie (categorie_id)
)
 
 ";

?>