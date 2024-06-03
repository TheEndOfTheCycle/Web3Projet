<?php
require_once "../config.php";
require_once "../class/Autoloader.php";
Autoloader::register();

if (isset($_GET['id'])) {
    $filmTitle = $_GET['id'];
    
    $filmsClass = new Films();
    $film = $filmsClass->getFilm($filmTitle);


        $listesClass = new Watchlists();
        $listesClass->add_film_to_db(11, 0);
        $existingFilm = $listesClass->getFilm($filmTitle);
        if (!$existingFilm) {
            $listesClass->add_film_to_db($filmTitle, 0);
            
            echo "Film ajouté à la liste";
        } else {
            echo "Le film est déjà dans la liste";
        }

} else {
    echo "ID du film non spécifié";
}
