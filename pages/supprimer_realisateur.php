<?php
// Inclure votre fichier de configuration et votre classe Acteurs
require_once "../config.php";
require "../class/Autoloader.php";
Autoloader::register();

// Vérifier si l'identifiant de l'acteur à supprimer est passé en paramètre
if (isset($_GET['id'])) {
    // Récupérer l'identifiant de l'acteur à supprimer depuis la requête GET
    $realId = $_GET['id'];

    // Créer une instance de la classe Acteurs
    $realisateur = new Realisateurs();

    // Supprimer l'acteur de la base de données en utilisant l'identifiant récupéré
    $realisateur->remove_real_from_db($realId);

    // Envoyer une réponse JSON pour indiquer que la suppression s'est bien passée
    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
} else {
    // Envoyer une réponse JSON pour indiquer qu'il manque l'identifiant de l'acteur
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Identifiant de l\'acteur manquant']);
}