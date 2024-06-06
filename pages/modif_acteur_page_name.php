<?php
require_once "../config.php";
require "../class/Autoloader.php";
Autoloader::register();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modif'])) {
    $newActName = $_POST['modif']; 
    $idAct = $_GET['num_act'];

    if ($idAct) {
        $acteur = new acteurs();   

        // Vérifiez si le nouveau synopsis est vide
        if (empty($newActName)) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Le nom de acteur du film ne peut pas être vide']);
            exit;
        }

        // Mettre à jour l'synopsis du film
        $acteur->updateActorName($idAct, $newActName);

        $nomActeur = $acteur->getnomActeur($idAct);
       
        header("Location: acteur.php?nom_act=" . urlencode($nomActeur));
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

