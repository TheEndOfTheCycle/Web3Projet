<?php
require_once "../config.php";
require_once "../class/Autoloader.php";
Autoloader::register();
session_start();

// Instanciation de la classe Watchlists pour récupérer les films de la watchlist de l'utilisateur
$watchlistClass = new Watchlists();

// Récupérer les numéros de films de la watchlist
$numFilms = $watchlistClass->getAllFilmTitles(); // Assuming you have a method like this in your Watchlists class
$films = new Films();


?>

<!-- Démarre le buffering -->
<?php ob_start() ?>

<div class="container-films">
    <h1>Ma Liste de Films</h1>

    <?php if (empty($numFilms) || !is_array($numFilms)): ?>
        <p>Votre liste est vide.</p>
    <?php else: ?>
        <div class="acteurs-realisateurs">
            <?php foreach ($numFilms as $num): ?>
                <?php $film = $films->getFilm($num); ?>
                    
                    <div class="image-container">
                        <a href="movies.php??nom_film=<?= $film->titre_film ?>" class="film-min">
                            <img src="../images/affiches/<?= htmlspecialchars($film->nom_affiche, ENT_QUOTES, 'UTF-8'); ?>"
                                alt="<?= htmlspecialchars($film->titre_film, ENT_QUOTES, 'UTF-8'); ?>">
                            <span><?= htmlspecialchars($film->titre_film, ENT_QUOTES, 'UTF-8') ?></span>
                        </a>
                    </div>

            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php $content = ob_get_clean() ?>
<?php Template::render($content) ?>
