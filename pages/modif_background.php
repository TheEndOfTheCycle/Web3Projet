<?php
require_once "../config.php";
require "../class/Autoloader.php";
Autoloader::register();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['modif_image']) && isset($_GET['background'])) {
    $idReal = $_GET['background'];
    $newImageName = $_FILES['modif_image']['name']; // Nouveau nom du fichier image
    $newImagePath = $_FILES['modif_image']['tmp_name']; // Chemin temporaire du fichier image

    if ($idReal) {
        $films = new Films();

        // Vérifiez si un fichier a été correctement uploadé
        if (is_uploaded_file($newImagePath)) {
            // Déplacez le fichier uploadé vers le dossier de destination
            $uploadDir = "../images/affiches/"; // Mettez le chemin vers le dossier d'images
            $newImageDestination = $uploadDir . $newImageName;
            move_uploaded_file($newImagePath, $newImageDestination);

            // Mettre à jour le nom de l'image du réalisateur dans la base de données
            $films->updateImageByNumFilm($idReal, $newImageName);

            $film = $films->getFilmByNum($idReal);
            $title = $film->titre_film;
       
            header("Location: movies.php?nom_film=" . urlencode($title));
            exit; // Assurez-vous que le script s'arrête après la redirection// Assurez-vous que le script s'arrête après la redirection
        } else {
            // Gérer les erreurs liées au téléchargement du fichier
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Erreur lors du téléchargement du fichier']);
            exit;
        }
    } else {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'id du réalisateur manquant']);
        exit;
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Requête invalide']);
    exit;
}