<?php
require_once "../config.php";
require "../class/Autoloader.php";
Autoloader::register();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modif'])) {
    $newYear = $_POST['modif']; 
    $idFilm = $_GET['annee'];

    if ($idFilm) {
        $films = new Films();    

        // Vérifiez si le nouveau synopsis est vide
        if (empty($newYear)) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'L annee du film ne peut pas être vide']);
            exit;
        }

        // Mettre à jour l'synopsis du film
        $films->updateFilmYear($idFilm, $newYear);

        // Rediriger vers la page des films avec le nom du film mis à jour
        $film = $films->getFilmByNum($idFilm);
        $titre = $film->titre_film;
        header("Location: movies.php?nom_film=" . urlencode($titre));
        exit; // Assurez-vous que le script s'arrête après la redirection

    } else {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'id du film manquant']);
        exit;
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Requête invalide']);
    exit;
}
