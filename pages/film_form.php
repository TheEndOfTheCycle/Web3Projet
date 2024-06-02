<?php
require_once "../config.php";
require ".." . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'Autoloader.php';
Autoloader::register();

$ff = new FilmForm();

// Démarre le buffering
ob_start();

// Vérifier si les champs ne sont pas vides
if (empty($_POST['titre']) || empty($_POST['annee']) || empty($_POST['description']) || empty($_POST['genre']) || empty($_POST['real']) || (empty($_FILES['affiche']['name']) && empty($_FILES['affiche']['tmp_name']))) {
    $ff->generateForm();
} else {
    $afficheFile = isset($_FILES['affiche']) ? $_FILES['affiche'] : null;
    $ff->createFilm($_POST['titre'], $_POST['annee'], $_POST['genre'], $_POST['real'], $afficheFile, $_POST['description']);
}

$content = ob_get_clean();
Template::render($content);
