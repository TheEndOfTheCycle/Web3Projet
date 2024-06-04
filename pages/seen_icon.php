<?php
require_once "../config.php";
require_once "../class/Autoloader.php";
Autoloader::register();

if (isset($_GET['id'])) {
    $filmNum = $_GET['id'];

    // Créez une instance de la classe Films pour gérer l'état du film
    $filmsClass = new Films();
    $existingFilm = $filmsClass->getFilmByNum($filmNum);
    $title = $existingFilm->titre_film;

    if ($filmsClass->filmExists($title)) {
        $etat = $existingFilm->est_regarde; // Assurez-vous de récupérer la propriété correctement

        // Inversez l'état du film
        $nouvelEtat = $etat ? 0 : 1;

        $filmsClass->updateEtat($filmNum, $nouvelEtat);

        echo "État du film mis à jour avec succès.";
    } else {
        echo "Le film n'existe pas dans la base de données.";
    }
} else {
    echo "ID du film non spécifié.";
}
