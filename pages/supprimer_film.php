<?php
// Inclure votre fichier de configuration et votre classe Films
require_once "../config.php";
require "../class/Autoloader.php";
Autoloader::register();

// Vérifier si l'identifiant du film à supprimer est passé en paramètre
if (isset($_GET['id'])) {
    // Récupérer l'identifiant du film à supprimer depuis la requête GET
    $filmId = $_GET['id'];

    // Créer une instance de la classe Films
    $films = new Films();

    // Supprimer le film de la base de données en utilisant l'identifiant récupéré
    $films->remove_film_from_db($filmId);

    // Envoyer une réponse JSON pour indiquer que la suppression s'est bien passée
    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
} else {
    // Envoyer une réponse JSON pour indiquer qu'il manque l'identifiant du film
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Identifiant du film manquant']);
}
?>
