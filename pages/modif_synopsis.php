<?php
require_once "../config.php";
require "../class/Autoloader.php";
Autoloader::register();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modif'])) {
    $newsynopsis = $_POST['modif']; 
    $idFilm = $_GET['synopsis'];

    if ($idFilm) {
        $films = new Films();    

        // Vérifiez si le nouveau synopsis est vide
        if (empty($newsynopsis)) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'L\'synopsis du film ne peut pas être vide']);
            exit;
        }

        // Mettre à jour l'synopsis du film
        $films->updateFilmSynopsis($idFilm, $newsynopsis);

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
?>
