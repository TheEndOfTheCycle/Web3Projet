<?php
require_once "../config.php";
require ".." . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'Autoloader.php';
Autoloader::register();
session_start();

if (isset($_GET['nom_film'])) {
    $nomFilm = $_GET['nom_film'];
    $filmDetails = (new Film())->getFilm($nomFilm);
}
?>

<?php ob_start() ?>

<div class="background" style="background-image: linear-gradient(to right, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0)), url('../images/affiches/<?php echo htmlspecialchars($filmDetails->nom_affiche, ENT_QUOTES, 'UTF-8'); ?>.jpg');">    <header>
        <div id="header">
            <div class="container">
                <nav>
                    <a href="../index.php" id="logo">
                        <span id="first-letter">C</span>ine<span id="first-letter">C</span>ollection
                    </a>
                    <ul id="sidemenu">
                        <li><a href="../index.php">Accueil</a></li>
                        <li><a href="films.php">Films</a></li>
                        <li><a href="acteurs.php">Acteurs</a></li>
                        <li><a href="realisateurs.php">Réalisateurs</a></li>
                        <li><a href="tags.php">Tags</a></li>
                        <?php 
                            if(isset($_SESSION['username'])) {
                                echo '<li><a href="logout.php">Déconnexion Admin</a></li>';
                            } else {
                                echo '<li><a href="logging.php">Connexion Admin</a></li>';
                            }
                        ?>
                        <li id="search-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                            </svg>
                        </li>
                        <i class="fa-solid fa-xmark"></i>
                    </ul>
                    <i class="fa-solid fa-bars"></i>
                </nav>
            </div>
        </div>
        <form class="search-form">
            <div class="search-bar">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                    </svg>
                </span>
                <input type="text" id="search-input" placeholder="Rechercher...">
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
            </svg>
        </form>
    </header>

    <div class="container-movie">
        <?php if (isset($filmDetails) && $filmDetails): ?>
            <div class="infoMovie1">
                <div class="infoMovie2">
                    <h1><?= htmlspecialchars($filmDetails->titre_film, ENT_QUOTES, 'UTF-8'); ?></h1>
                    <h4><?= htmlspecialchars($filmDetails->anSortie_film, ENT_QUOTES, 'UTF-8'); ?></h4>
                    <h4><?= htmlspecialchars($filmDetails->synopsis, ENT_QUOTES, 'UTF-8'); ?></h4>
                    <h4><?= htmlspecialchars(implode(" | ", $filmDetails->getTagsNames()), ENT_QUOTES, 'UTF-8'); ?></h4>
                    <div class="icons-movie">
                        <!-- Movie icons -->
                    </div>
                </div>
                <div class="infoMovie2">
                    <div class="cat1">
                        <span>Réalisateur: <?= htmlspecialchars($filmDetails->getNomReal(), ENT_QUOTES, 'UTF-8'); ?></span>
                        <img src="<?= "../images/realisateurs/" . htmlspecialchars($filmDetails->getNomReal(), ENT_QUOTES, 'UTF-8') . ".jpg" ?>" alt="Réalisateur">
                    </div>
                </div>
            </div>
            <div class="film-categorie">
                <span class="film-categorie-name">Acteurs</span>
                <div class="carousel-container">
                    <div class="carousel-arrow left-arrow">&#10094;</div>
                    <div class="films">
                        <?php foreach ($filmDetails->getNomsActors() as $actor): ?>
                            <div class="acteur-scroll">
                                <img src="<?= "../images/acteurs/" . htmlspecialchars($actor, ENT_QUOTES, 'UTF-8') . ".jpg" ?>" alt="<?= htmlspecialchars($actor, ENT_QUOTES, 'UTF-8'); ?>">
                                <span><?= htmlspecialchars($actor, ENT_QUOTES, 'UTF-8'); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="carousel-arrow right-arrow">&#10095;</div>
                </div>
            </div>
        <?php else: ?>
            <p>Film non trouvé.</p>
        <?php endif; ?>
    </div>

<?php $content = ob_get_clean() ?>
<?php Template_movie::render($content) ?>
