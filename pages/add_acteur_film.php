<?php
require_once "../config.php";
require "../class/Autoloader.php";
Autoloader::register();

if (isset($_GET['id']) && isset($_GET['num_film'])) {
    $actId = $_GET['id'];
    $filmId = $_GET['num_film'];

    $acteurs = new Acteurs();

    // Vérifier si l'acteur est déjà associé au film
    $isActorInFilm = $acteurs->check_actor_in_film($actId, $filmId);

    if ($isActorInFilm) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'L\'acteur est déjà associé à ce film']);
    } else {
        // Ajouter l'acteur au film
        $acteurs->add_role($actId, $filmId);

        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Identifiant de l\'acteur ou du film manquant']);
}
