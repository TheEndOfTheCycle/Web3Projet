<?php
require_once "../config.php";
require ".." . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'Autoloader.php';
Autoloader::register();

$gf = new RealisateurForm();

// Démarre le buffering
ob_start();

if (empty($_POST['name'])) {
    $gf->generateForm();
} else {
    $imgFile = isset($_FILES['image']) ? $_FILES['image'] : null;
    $gf->createRealisateur($_POST['name'], $imgFile);
}

$content = ob_get_clean();
Template::render($content);