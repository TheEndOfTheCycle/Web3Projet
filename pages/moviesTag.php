<?php
require_once "../config.php";
require ".." . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'Autoloader.php';
Autoloader::register();
session_start();


// Récupérer le nom du tag depuis l'URL
$tag = isset($_GET['tag']) ? $_GET['tag'] : null;

if ($tag) {
    // Instancier la classe Films et récupérer tous les films
    $filmsClass = new Films();
    $allFilms = $filmsClass->getAllFilms();

    // Filtrer les films par le nom du tag
    $filteredFilms = array_filter($allFilms, function($film) use ($tag) {
        return in_array($tag, $film->getTagsNames());
    });
}
?>

<!-- Démarre le buffering -->
<?php ob_start() ?>
<div class="container-films">
    <h1><?php echo htmlspecialchars($tag, ENT_QUOTES, 'UTF-8'); ?></h1>

    <div class="film-categorie">
        <div class="films-tag">
            <?php if (!empty($filteredFilms)): ?>
                <?php foreach ($filteredFilms as $film): ?>
                    <a href="movies.php?nom_film=<?= urlencode($film->titre_film) ?>" class="film-min">
                        <div class="image-container">
                            <img src="../images/affiches/<?php echo htmlspecialchars($film->nom_affiche, ENT_QUOTES, 'UTF-8'); ?>.jpg" alt="<?php echo htmlspecialchars($film->titre_film, ENT_QUOTES, 'UTF-8'); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-eye seen-icon hidden" viewBox="0 0 16 16">
                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                            </svg>
                            <svg id="add-icon" title="Ajouter à la liste" xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-plus-lg watch-list-icon hidden" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
                            </svg>
                        </div>
                        <span><?php echo htmlspecialchars($film->titre_film, ENT_QUOTES, 'UTF-8'); ?></span>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun film trouvé pour le tag: <?php echo htmlspecialchars($tag, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Récupère le contenu du buffer (et le vide) -->
<?php $content = ob_get_clean() ?>

<!-- Utilisation du contenu bufferisé -->
<?php Template::render($content) ?>