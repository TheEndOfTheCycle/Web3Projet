<?php
require_once "../config.php";
require ".." . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'Autoloader.php';
Autoloader::register();
session_start();

if (isset($_GET['nom_film'])) {
    $nomFilm = $_GET['nom_film'];
    $filmDetails = (new Film())->getFilm($nomFilm);
    $num_film = $filmDetails->num_film;
}


?>

<?php ob_start() ?>

<div class="background"
    style="background-image: linear-gradient(to right, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0)), url('../images/affiches/<?php echo htmlspecialchars($filmDetails->nom_affiche, ENT_QUOTES, 'UTF-8'); ?>');">
    <header>
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
                    if (isset($_SESSION['username'])) {
                        // Utilisateur connecté, affiche le lien de déconnexion
                        echo '<li><a href="logout.php">Déconnexion Admin</a></li>';
                    } else {
                        // Utilisateur non connecté, affiche le lien de connexion
                        echo '<li><a href="logging.php">Connexion Admin</a></li>';
                    }
                    ?>
                    <li id="search-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-search" viewBox="0 0 16 16">
                            <path
                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                        </svg>
                    </li>

                    <i class="fa-solid fa-xmark"></i>
                </ul>

                <i class="fa-solid fa-bars"></i>
            </nav>
        </div>
    </div>
    <form class="search-form">
        <div class="searche-bar">
            <div class="searche-bar-1">

                <button type="submit" class="search-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-search" viewBox="0 0 16 16">
                        <path
                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                    </svg>
                </button>
                <input type="text" id="search-input" placeholder="Rechercher...">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                    class="bi bi-x-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                    <path
                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                </svg>
            </div>
            <div id="search-results"></div>
        </div>


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
                        <span><?= htmlspecialchars($filmDetails->getNomReal(), ENT_QUOTES, 'UTF-8'); ?></span>
                        <img src="<?= "../images/realisateurs/" . htmlspecialchars($filmDetails->getNomImgReal(), ENT_QUOTES, 'UTF-8') ?>"
                            alt="Réalisateur">
                    </div>
                </div>
            </div>
            <div class="film-categorie">
                <span class="acteur-film">Acteurs
                    <a href="add_acteur.php?num_film=<?= htmlspecialchars($filmDetails->num_film, ENT_QUOTES, 'UTF-8'); ?>"
                        class="btn btn-primary">Ajouter des acteurs ></a>
                </span>
                <div class="carousel-container">
                    <div class="carousel-arrow left-arrow">&#10094;</div>
                    <div class="films">
                        <?php foreach ($filmDetails->getActors() as $actor): ?>
                            <?php
                            $acteur = new Acteurs();
                            $num_act = $acteur->getNumAct($actor->nom_act);
                            ?>
                            <div class="acteur-scroll cat1">
                                <img src="<?= "../images/acteurs/" . $actor->nom_img ?>"
                                    alt="<?= htmlspecialchars($actor->nom_act, ENT_QUOTES, 'UTF-8'); ?>">
                                <?php if (isset($_SESSION['username'])): ?>
                                    <svg id="delete-icon-<?= $num_act ?>" xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                        fill="currentColor" class="bi bi-trash3 hidden c" viewBox="0 0 16 16">
                                        <path
                                            d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                                    </svg>
                                <?php endif; ?>
                                <span><?= htmlspecialchars($actor->nom_act, ENT_QUOTES, 'UTF-8'); ?></span>
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.c').forEach(icon => {
                icon.addEventListener('click', function () {
                    let actorId = this.id.replace('delete-icon-', '');
                    deleteActor(actorId);
                });
            });
        });

        function deleteActor(actorId) {
            let filmId = <?= json_encode($num_film) ?>;
            console.log(actorId)
            console.log(filmId)

            fetch('supprimer_acteur_film.php?id=' + actorId + '&num_film=' + filmId, {
                method: 'GET'
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        console.error('Erreur lors de la suppression de l\'acteur');
                    }
                })
                .catch(error => {
                    console.error('Erreur lors de la suppression de l\'acteur :', error);
                });
        }
    </script>

    <?php $content = ob_get_clean() ?>
    <?php Template_movie::render($content) ?>