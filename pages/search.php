<?php
// Inclure votre fichier de configuration et la classe Autoloader
require_once "../config.php";
require "../class/Autoloader.php";
Autoloader::register();

// Vérifier si le terme de recherche est présent dans les paramètres GET
if (isset($_GET['query'])) {
    $query = trim($_GET['query']);

    // Vérifier que le terme de recherche n'est pas vide
    if (!empty($query)) {
        // Créer une instance de la classe Trie
        $trie = new Trie();


        // Effectuer la recherche de films
        $resultAll = $trie->searchMovies($query);
       

        // Vérifier si des résultats ont été trouvés
        if ($resultAll !== false && !empty($resultAll)) {
            // Convertir les résultats en un tableau associatif approprié pour le JSON
            $jsonResults = array();
            foreach ($resultAll as $result) {
                $jsonResults[] = array(
                    'titre_film' => htmlspecialchars($result->titre_film, ENT_QUOTES, 'UTF-8'),
                    'img_film' => htmlspecialchars($result->nom_affiche, ENT_QUOTES, 'UTF-8'),
                    'anSortie_film' => htmlspecialchars($result->anSortie_film, ENT_QUOTES, 'UTF-8'),
                    'genre' => htmlspecialchars($result->genre_film, ENT_QUOTES, 'UTF-8'), // Il serait préférable de rendre ce champ dynamique
                );
            }

            // Renvoyer les résultats au format JSON
            echo json_encode($jsonResults);
        } else {
            // Aucun résultat trouvé
            http_response_code(404);
            echo json_encode(array('error' => 'No movies found'));
        }
    } else {
        // Terme de recherche vide
        http_response_code(400);
        echo json_encode(array('error' => 'Empty search query provided'));
    }
} else {
    // Aucun terme de recherche fourni
    http_response_code(400);
    echo json_encode(array('error' => 'No search query provided'));
}
