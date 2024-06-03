<?php
require_once "../config.php";
require_once "../class/Autoloader.php";
Autoloader::register();

if (isset($_GET['id'])) {
    $filmNum = $_GET['id'];


        // Créez une instance de la classe Watchlists pour gérer la watchlist
        $listesClass = new Watchlists();
        $existingInWatchlist = $listesClass->getFilm($filmNum);
        $temp = $existingInWatchlist->num_film;
        $etat = $existingInWatchlist->est_regarde;

        if ($listesClass->filmExists($temp)) {
            // Ajoutez le film à la watchlist
            if($etat){
                $listesClass->updateEtat($filmNum,0);
            }else{
                $listesClass->updateEtat($filmNum,1);
            }
            echo "Film ajouté à la liste";
        } else {
            echo "Le film est déjà dans la liste";
        }
  
} else {
    echo "ID du film non spécifié";
}
?>
