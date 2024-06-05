<?php
require_once "../config.php";
require "../class/Autoloader.php";
Autoloader::register();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modif'])) {
    $newTags = $_POST['modif']; 
    $tableau = explode(',', $newTags); // Correction: utiliser explode au lieu de split
    $idFilm = $_GET['tag'];

    if ($idFilm) {
        $films = new Films();
        $tags = new Tags();

        // Vérifiez si le nouveau tag est vide
        if (empty($newTags)) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Le tag du film ne peut pas être vide']);
            exit;
        }

        // Mettre à jour les tags du film
        $films->updateFilmTag($idFilm, $tableau);

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
