<?php
require_once "../config.php";
require "../class/Autoloader.php";
Autoloader::register();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['modif_image']) && isset($_GET['image'])) {
    $idReal = $_GET['image'];
    $newImageName = $_FILES['modif_image']['name']; // Nouveau nom du fichier image
    $newImagePath = $_FILES['modif_image']['tmp_name']; // Chemin temporaire du fichier image

    if ($idReal) {
        $realisateur = new Realisateurs();

        // Vérifiez si un fichier a été correctement uploadé
        if (is_uploaded_file($newImagePath)) {
            // Déplacez le fichier uploadé vers le dossier de destination
            $uploadDir = "chemin/vers/votre/dossier/image/"; // Mettez le chemin vers le dossier d'images
            $newImageDestination = $uploadDir . $newImageName;
            move_uploaded_file($newImagePath, $newImageDestination);

            // Mettre à jour le nom de l'image du réalisateur dans la base de données
            $realisateur->updateImageByNumReal($idReal, $newImageName);

            $title = $films->getFilmTitleByNumReal($idReal);
       
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