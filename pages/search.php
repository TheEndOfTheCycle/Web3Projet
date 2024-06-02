<?php
// Inclure votre fichier de configuration et la classe Trie
require_once "../config.php";
require "../class/Autoloader.php";
Autoloader::register();

// Vérifier si le terme de recherche est présent dans les paramètres GET
if (isset($_GET['query'])) {
    $query = trim($_GET['query']);

    // Créer une instance de la classe Trie
    $trie = new Trie();
    if(!empty($query)){
        $resultAll= $trie->searchMovies($query);
    }
    
    // Convertir les résultats en un tableau associatif approprié pour le JSON
    $jsonResults = array();
    foreach ($resultAll as $result) {
        $jsonResults[] = array(
            'titre_film' => $result->titre_film,
            'img_film' => $result->nom_affiche,
            'anSortie_film' => $result->anSortie_film,
            'genre_film' => $result->genre_film,
        );
    }


    // Renvoyer les résultats au format JSON
    echo json_encode($jsonResults);
} else {
    // Renvoyer une réponse d'erreur si aucun terme de recherche n'est fourni
    http_response_code(400);
    echo json_encode(array('error' => 'No search query provided'));
}