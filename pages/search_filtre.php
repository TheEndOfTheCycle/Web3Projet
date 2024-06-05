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
$numReal = '';
$actorIds = [];

// Récupérer le numéro du réalisateur
if(!empty($directorName)){
    $realisateur = new Realisateurs();
    if($realisateur->realisateurExist($directorName)){
        $numReal = $realisateur->getNumReal($directorName);
    }else{
        $numReal = -1;
    }
}

// Récupérer les IDs des acteurs
if(!empty($actorName)){
    $actorNames = explode(',', $actorName);
    $acteur = new Acteurs();
    foreach ($actorNames as $name) {
        $actorIds[] = $acteur->getNumAct(trim($name));
    }
}

// Récupérer les films correspondants
$movies = $trie->getMoviesByDirectorIdGenreYear($numReal, $genre, $year, $seen, $actorIds);

// Afficher les résultats
if (!empty($movies)) {
    foreach ($movies as $movie) {
        echo "Titre : " . $movie->titre_film . "<br>";
        echo "Année : " . $movie->anSortie_film . "<br>";
        echo "Genre : " . $movie->genre_film . "<br>";
        echo "Réalisateur : " . $movie->num_real . "<br>";
        echo "Affiche : " . $movie->nom_affiche . "<br><br>";
    }
} else {
    echo "Aucun film trouvé pour ces critères.";
}
?>
