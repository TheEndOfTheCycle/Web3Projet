<?php
require_once "../config.php";

require ".." . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'Autoloader.php';
Autoloader::register();


?>

<!-- Démarre le buffering -->
<?php ob_start() ?>

<div class="container-tags">
        <h1>Categories</h1>
        <h3>Genres</h3>
        <div class="categories">
            <a href="moviesTag.php" class="cat2">
                Comedie
            </a href="moviesTag.php">
            <a href="moviesTag.php" class="cat2">
                Horreur
            </a href="moviesTag.php">
            <a href="moviesTag.php" class="cat2">
                Horreur
            </a href="moviesTag.php">
            <a href="moviesTag.php" class="cat2">
                Horreur
            </a href="moviesTag.php">
            <a href="moviesTag.php" class="cat2">
                Horreur
            </a href="moviesTag.php">
            <a href="moviesTag.php" class="cat2">
                Horreur
            </a href="moviesTag.php">
            <a href="moviesTag.php" class="cat2">
                Horreur
            </a href="moviesTag.php">
            <a href="moviesTag.php" class="cat2">
                Horreur
            </a href="moviesTag.php">
        </div>
    </div>
<!-- Récupère le contenu du buffer (et le vide) -->
<?php $content = ob_get_clean() ?>
<!-- Utilisation du contenu bufferisé -->
<?php Template::render($content) ?>