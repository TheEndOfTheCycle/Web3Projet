<?php
require_once "../config.php";
require "../class/Autoloader.php";
Autoloader::register();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modif'])) {
    $newsynopsis = $_POST['modif']; 
    $idReal = $_GET['num_real'];

    if ($idReal) {
        $films = new Films(); 
        $realisateur = new Realisateurs();   

        // Vérifiez si le nouveau synopsis est vide
        if (empty($newsynopsis)) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'L\'synopsis du film ne peut pas être vide']);
            exit;
        }

        // Mettre à jour l'synopsis du film
        $realisateur->updateRealisateurName($idReal, $newsynopsis);

        // Rediriger vers la page des films avec le nom du film mis à jour
        $title = $films->getFilmTitleByNumReal($idReal);
       
        header("Location: movies.php?nom_film=" . urlencode($title));
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

