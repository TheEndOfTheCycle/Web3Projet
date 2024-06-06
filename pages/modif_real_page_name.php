<?php
require_once "../config.php";
require "../class/Autoloader.php";
Autoloader::register();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modif'])) {
    $newNameReal = $_POST['modif']; 
    $idReal = $_GET['num_real'];

    if ($idReal) {
        $realisateur = new Realisateurs();   

        // Vérifiez si le nouveau synopsis est vide
        if (empty($newNameReal)) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Le nom du realisateur du film ne peut pas être vide']);
            exit;
        }

        // Mettre à jour l'synopsis du film
        $realisateur->updateRealisateurName($idReal, $newNameReal);

        $nomReal = $realisateur->getNomReal($idReal);
       
        header("Location: realisateur.php?nom_real=" . urlencode($nomReal));
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

