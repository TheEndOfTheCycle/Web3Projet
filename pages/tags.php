<?php
require_once "../config.php";
require ".." . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'Autoloader.php';
Autoloader::register();
session_start();

// Utilisation de la classe Tags
$tags = new Tags();

// Récupération de tous les tags depuis la base de données
$allTags = $tags->getAllTags();
?>

<!-- Démarre le buffering -->
<?php ob_start() ?>

<div class="container-tags">
    <h1>Categories</h1>
    <h3>Genres</h3>
    <div class="categories">
        <?php foreach ($allTags as $tag): ?>
            <a href="moviesTag.php?tag=<?php echo urlencode($tag->nom_tag); ?>" class="cat2">
                <?php echo htmlspecialchars($tag->nom_tag, ENT_QUOTES, 'UTF-8'); ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>


<!-- Récupère le contenu du buffer (et le vide) -->
<?php $content = ob_get_clean() ?>

<!-- Utilisation du contenu bufferisé -->
<?php Template::render($content) ?>