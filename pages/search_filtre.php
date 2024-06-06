<?php

// Inclure votre fichier de configuration et la classe Autoloader
require_once "../config.php";
require "../class/Autoloader.php";
Autoloader::register();

// Récupérer les valeurs des paramètres GET
$year = isset($_GET['year']) ? $_GET['year'] : '';
$genre = isset($_GET['genre']) ? $_GET['genre'] : '';
$directorName = isset($_GET['realisateur']) ? $_GET['realisateur'] : '';
$seen  =  isset($_GET['seen']) ? $_GET['seen'] : '';
$actorName  =  isset($_GET['acteur']) ? $_GET['acteur'] : '';

// Créer une instance de la classe Trie
$trie = new Trie();
$numReal = [];
$actorIds = [];

/// Récupérer les IDs des acteurs dont le nom contient la chaîne de caractères entrée
if (!empty($actorName)) {
    $acteur = new Acteurs();
    $actors = array_map('trim', explode(',', $actorName));
    $actorIds = [];

    foreach ($actors as $actor) {
        if (!empty($actor)) {
            $actorResults = $trie->searchActor($actor);
            if (!empty($actorResults)) {
                foreach ($actorResults as $actorObj) {
                    $trimmedName = trim($actorObj->nom_act);
                    if (!empty($trimmedName)) {
                        $numAct = $acteur->getNumAct($trimmedName);
                        if ($numAct !== null) {
                            $actorIds[] = $numAct;
                        } else {
                            $actorIds[] = -1;
                        }
                    }
                }
            } else {
                $actorIds[] = -1;
            }
        }
    }
} else {
    $actorIds = [];
}


// Récupérer les IDs des réalisateurs dont le nom contient la chaîne de caractères entrée
if(!empty($directorName)){
    $realisateur = new Realisateurs();
    $real = $trie->searchReal($directorName);

    // Si des réalisateurs correspondent au nom recherché
    if (!empty($real)) {
        foreach ($real as $r) {
            // Ajouter les IDs des réalisateurs à $numReal
            $numReal[] = $r->num_real;
        }
    } else {
        // Si aucun réalisateur correspondant n'est trouvé, ajouter un ID invalide (-1) à $numReal
        $numReal[] = -1;
    }
}

// Récupérer les films correspondants en utilisant les ID des acteurs et des réalisateurs
$movies = $trie->getMoviesByDirectorIdGenreYear($numReal, $genre, $year, $seen, $actorIds);


// Préparer les résultats pour le retour JSON
$results = [];
$tempo=array();
if (!empty($movies)) {
    foreach ($movies as $movie) {
        foreach($movie->getTags() as $tag)
        {
            $tempo []=  $tag->nom_tag . " ";
        }
        $results[] = [
            "titre_film" => $movie->titre_film,
            "anSortie_film" => $movie->anSortie_film,
            "genre_film" => htmlspecialchars(implode(" ",$tempo), ENT_QUOTES, 'UTF-8'),
            "num_real" => $movie->num_real,
            "nom_affiche" => $movie->nom_affiche,
        ];
        $tempo= array();
    }
}

// Retourner les résultats en JSON
header('Content-Type: application/json');
echo json_encode($results);
?>