<?php
require_once "../config.php";
require_once "../class/Autoloader.php";
Autoloader::register();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['modif_image']) && isset($_GET['image'])) {
    $idAct = $_GET['image'];
    $newImageName = $_FILES['modif_image']['name']; // Nouveau nom du fichier image
    $newImagePath = $_FILES['modif_image']['tmp_name']; // Chemin temporaire du fichier image

    if ($idAct) {
        $acteur = new acteurs();

        // Vérifiez si un fichier a été correctement uploadé
        if (is_uploaded_file($newImagePath)) {
            // Déplacez le fichier uploadé vers le dossier de destination
            $uploadDir = "../images/acteurs/"; // Mettez le chemin vers le dossier d'images
            $newImageDestination = $uploadDir . $newImageName;
            move_uploaded_file($newImagePath, $newImageDestination);

            // Mettre à jour le nom de l'image du réalisateur dans la base de données
            $acteur->updateImageByNumAct($idAct, $newImageName);

            $nomActeur = $acteur->getnomActeur($idAct);
       
            header("Location: acteur.php?nom_act=" . urlencode($nomActeur));
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