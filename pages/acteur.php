<?php
require_once "../config.php";
require ".." . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'Autoloader.php';
Autoloader::register();
session_start();

$acteurDetails = null;
$films = [];

if (isset($_GET['nom_act'])) {
    $nomact = $_GET['nom_act'];
    $acteurDetails = (new Acteurs())->getActeur($nomact);

    if ($acteurDetails) {
        $num_acteur = $acteurDetails->num_act;
        $films = $acteurDetails->getMovies($num_acteur);

    }
}

?>

<?php ob_start() ?>

<div class="container-movie">
    <?php if (isset($acteurDetails) && $acteurDetails): ?>
        <div class="infoMovie1">
            <div class="infoMovie2">
                <h1><?= htmlspecialchars($acteurDetails->nom_act, ENT_QUOTES, 'UTF-8'); ?></h1>
                <img src="<?= "../images/acteurs/" . htmlspecialchars($acteurDetails->nom_img, ENT_QUOTES, 'UTF-8') ?>"
                    alt="<?= htmlspecialchars($acteurDetails->nom_act, ENT_QUOTES, 'UTF-8'); ?>">
            </div>
        </div>
        <div class="film-categorie">
            <span class="acteur-film">Films réalisés</span>
            <div class="carousel-container">
                <div class="carousel-arrow left-arrow">&#10094;</div>
                <div class="films">
                    <?php foreach ($films as $film): ?>
                        <div class="image-container ">
                            <a class="film-min" href="movies.php?nom_film=<?= urlencode($film->titre_film) ?>">
                                <img src="<?= "../images/affiches/" . htmlspecialchars($film->nom_affiche, ENT_QUOTES, 'UTF-8') ?>"
                                    alt="<?= htmlspecialchars($film->titre_film, ENT_QUOTES, 'UTF-8'); ?>">
                                <span><?= htmlspecialchars($film->titre_film, ENT_QUOTES, 'UTF-8'); ?></span>
                            </a>
                            <svg id="add-icon-<?= $film->num_film ?>" title="Ajouter à la liste"
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                                class="bi bi-plus-lg watch-list-icon act hidden" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2" />
                            </svg>
                            <?php if (isset($_SESSION['username'])): ?>
                                <svg id="delete-icon-<?= $film->num_film ?>" xmlns="http://www.w3.org/2000/svg" width="25"
                                    height="25" fill="currentColor" class="bi bi-trash-film hidden c" viewBox="0 0 16 16">
                                    <path
                                        d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                                </svg>
                            <?php endif; ?>
                            <?php if ($film->est_regarde == 0): ?>
                                <svg id="not-seen-icon-<?= $film->num_film ?>" xmlns="http://www.w3.org/2000/svg" width="25"
                                    height="25" fill="currentColor" class="bi bi-plus-lg watch-list-icon seen" viewBox="0 0 16 16">
                                    <path
                                        d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7 7 0 0 0-2.79.588l.77.771A6 6 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755q-.247.248-.517.486z" />
                                    <path
                                        d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829" />
                                    <path
                                        d="M3.35 5.47q-.27.24-.518.487A13 13 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7 7 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12z" />
                                </svg>
                            <?php else: ?>
                                <svg id="seen-icon-<?= $film->num_film ?>" xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                    fill="currentColor" class="bi bi-plus-lg watch-list-icon seen" viewBox="0 0 16 16">
                                    <path
                                        d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                    <path
                                        d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                </svg>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>

                </div>
                <div class="carousel-arrow right-arrow">&#10095;</div>
            </div>
        </div>

    <?php else: ?>
        <p>Acteur non trouvé.</p>
    <?php endif; ?>
    <?php
    if (!$films) {
        echo "Aucun film trouvé pour cet acteur.";
    }
    ?>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {

        document.querySelectorAll('.c').forEach(icon => {
            icon.addEventListener('click', function () {
                console.log("clic");
                // Obtenez l'identifiant unique de l'icône de corbeille
                let id = this.id.replace('delete-icon-', '');
                console.log(id);
                // Appelez une fonction pour supprimer le film avec cet identifiant
                deleteFilm(id);
            });
        });

        // Sélectionnez toutes les icônes de corbeille avec la classe "c" et ajoutez un gestionnaire d'événements à chacune
        document.querySelectorAll('.watch-list-icon').forEach(icon => {
            icon.addEventListener('click', function () {
                let id = this.id.replace('add-icon-', '');
                console.log(id);
                console.log("nemi")
                // Appelez une fonction pour supprimer le film avec cet identifiant
                addFilmToWatchlist(id);
            });
        });

        document.querySelectorAll('.seen').forEach(icon => {
            icon.addEventListener('click', function () {
                // Obtenez le numéro du film à partir de l'identifiant de l'icône
                let filmNum = this.id.split('-').pop();
                console.log(filmNum);
                // Appelez une fonction pour mettre à jour l'état du film avec ce numéro
                updateFilmStatus(filmNum);
            });
        });


    });

    function deleteFilm(filmId) {
        let actorId = <?= json_encode($num_acteur) ?>;
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

    function addFilmToWatchlist(filmTitle) {
        // Envoyez une requête AJAX pour supprimer le film correspondant
        fetch('ajouter_film_liste.php?id=' + filmTitle, {
            method: 'GET'
        })
            .then(response => {
                if (response.ok) {
                    // La suppression s'est bien passée, rafraîchir la page ou mettre à jour la liste des films
                    // Rafraîchir la page
                    window.location.reload(); // Rafraîchir la page
                } else {
                    // Gérer les erreurs de suppression
                    console.error('Erreur lors de la suppression du film');
                }
            })
            .catch(error => {
                console.error('Erreur lors de la suppression du film :', error);
            });
    }

    function updateFilmStatus(filmNum) {
        // Envoyez une requête AJAX à la page seen_icon.php pour mettre à jour l'état du film
        fetch('seen_icon.php?id=' + filmNum, {
            method: 'GET'
        })
            .then(response => {
                if (response.ok) {
                    // La mise à jour s'est bien passée, vous pouvez rafraîchir la page ou mettre à jour l'icône
                    window.location.reload(); // Rafraîchir la page
                } else {
                    // Gérer les erreurs de mise à jour
                    console.error('Erreur lors de la mise à jour de l\'état du film');
                }
            })
            .catch(error => {
                console.error('Erreur lors de la mise à jour de l\'état du film :', error);
            });
    }

</script>
<?php $content = ob_get_clean() ?>
<?php Template::render($content) ?>