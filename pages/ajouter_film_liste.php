<?php
require_once "../config.php";
require_once "../class/Autoloader.php";
Autoloader::register();

if (isset($_GET['id'])) {
    $filmNum = $_GET['id'];

    // Créez une instance de la classe Films pour vérifier si le film existe dans la base de données
    $filmsClass = new Films();
    $existingFilm = $filmsClass->getFilmByNum($filmNum);
    $titre = $existingFilm->titre_film;

    if ($filmsClass->filmExists($titre)) {

        // Créez une instance de la classe Watchlists pour gérer la watchlist
        $listesClass = new Watchlists();
        $existingInWatchlist = $listesClass->getFilm($filmNum);
        $temp = $existingInWatchlist->num_film;

        if (!$listesClass->filmExists($temp)) {
            // Ajoutez le film à la watchlist
            $listesClass->add_film_to_db($filmNum, $existingInWatchlist->est_regarde);
            echo "Film ajouté à la liste";
        } else {
            echo "Le film est déjà dans la liste";
        }
    } else {
        echo "Le film n'existe pas dans la base de données";
    }
} else {
    echo "ID du film non spécifié";
}
