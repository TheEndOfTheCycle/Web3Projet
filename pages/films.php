<?php
require_once "../config.php";
require_once "../class/Autoloader.php";
Autoloader::register();
session_start();


$tagModel = new Tags();
$tags = $tagModel->getAllTags();

$filmsClass = new Films();
$allFilms = $filmsClass->getAllFilms();

?>

<!-- Démarre le buffering -->
<?php ob_start() ?>

<div class="container-films">
    <div class="container-add-acteur">
        <div class="film-colone">
            <h1>Films</h1>
            <h4>Qu'il soit effrayant, comique, dramatique, romantique ou autre, le
                <br>cinéma sait éveiller nos sens. Et avec autant de titres disponibles, il y a
                <br> tellement de choses à découvrir !
            </h4>
        </div>
        <?php if (isset($_SESSION['username'])): ?>
            <a href="film_form.php" title="ajouter un film">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-plus-circle"
                    viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                    <path
                        d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                </svg>
            </a>

        <?php endif; ?>

    </div>


    <?php foreach ($tags as $tag): ?>
        <?php
        $filteredFilms = array_filter($allFilms, function ($film) use ($tag) {
            return in_array($tag->nom_tag, $film->getTagsNames());
        });
        if (empty($filteredFilms)) {
            continue;
        }
        ?>
        <div class="film-categorie">
            <span class="film-categorie-name"><?= htmlspecialchars($tag->nom_tag, ENT_QUOTES, 'UTF-8') ?> <a
                    href="moviesTag.php?tag=<?= urlencode($tag->nom_tag) ?>">&nbsp; See more ></a></span>
            <div class="carousel-container">
                <div class="carousel-arrow left-arrow">&#10094;</div>
                <div class="films">
                    <?php foreach ($filteredFilms as $film): ?>
                        <a href="movies.php?nom_film=<?= urlencode($film->titre_film) ?>" class="film-min">
                            <div class="image-container">
                                <img src="../images/affiches/<?= htmlspecialchars($film->nom_affiche, ENT_QUOTES, 'UTF-8'); ?>"
                                    alt="<?= htmlspecialchars($film->titre_film, ENT_QUOTES, 'UTF-8'); ?>">
                                <svg id="delete-icon" xmlns="http://www.w3.org/2000/svg" width="70" height="70"
                                    fill="currentColor" class="bi bi-trash-film hidden c" viewBox="0 0 16 16">
                                    <path
                                        d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                                </svg>
                                <svg id="add-icon" title="Ajouter à la liste" xmlns="http://www.w3.org/2000/svg" width="25"
                                    height="25" fill="currentColor" class="bi bi-plus-lg watch-list-icon hidden"
                                    viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2" />
                                </svg>
                            </div>
                            <span><?= htmlspecialchars($film->titre_film, ENT_QUOTES, 'UTF-8') ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
                <div class="carousel-arrow right-arrow">&#10095;</div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Récupère le contenu du buffer (et le vide) -->
<?php $content = ob_get_clean() ?>
<!-- Utilisation du contenu bufferisé -->
<?php Template::render($content) ?>