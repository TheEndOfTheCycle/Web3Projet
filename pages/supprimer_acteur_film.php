<?php
require_once "../config.php";
require "../class/Autoloader.php";
Autoloader::register();

if (isset($_GET['id']) && isset($_GET['num_film'])) {
    $actId = $_GET['id'];
    $filmId = $_GET['num_film'];

    $acteurs = new Acteurs();


    // Ajouter l'acteur au film
    $acteurs->remove_role($actId, $filmId);

    header('Content-Type: application/json');
    echo json_encode(['success' => true]);

} else {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Identifiant de l\'acteur ou du film manquant']);
}