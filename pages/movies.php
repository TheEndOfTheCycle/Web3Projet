<?php
require_once "../config.php";
require ".." . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'Autoloader.php';
Autoloader::register();
session_start();

if (isset($_GET['nom_film'])) {
    $nomFilm = $_GET['nom_film'];
    $film = new Film();
    if($film->existeFilm($nomFilm)){
        $filmDetails = $film->getFilm($nomFilm);
        $num_film = $filmDetails->num_film;
    }
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
                        <li><a href="liste.php">Ma liste</a></li>
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
        <div id="filter-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel"
                viewBox="0 0 16 16">
                <path
                    d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2z" />
            </svg>
        </div>
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

    <form class="filter-form" method="get" style="display:none">
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-circle-filter"
            viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
            <path
                d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
        </svg>
        <div class="filter-bar">
            <input type="text" id="year-input" name="year" placeholder="Année" class="filtre-input">
            <input type="text" id="genre-input" name="genre" placeholder="Genre" class="filtre-input">
            <input type="text" id="realisateur-input" name="realisateur" placeholder="Réalisateur" class="filtre-input">
            <input type="text" id="acteur-input" name="acteur" placeholder="Acteur" class="filtre-input">
            <div class="checkbox-container">
                <label for="seen-checkbox" class="vu">Vu</label>
                <input type="checkbox" id="seen-checkbox" name="seen" class="input-check">
            </div>
        </div>

        <div id="filter-results"></div>
    </form>
        
    </header>

    <div class="container-movie">
        <?php if (isset($_SESSION['username']) && !empty($filmDetails)): ?>
            <a href="modif.php?background=<?= urlencode($filmDetails->num_film) ?>" class="stylo">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill"
                    viewBox="0 0 16 16">
                    <path
                        d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z" />
                </svg>
                Modifier le background
            </a>
        <?php endif; ?>
        <?php if (isset($filmDetails) && $filmDetails): ?>
            <div class="infoMovie1">
                <div class="infoMovie2">
                    <h1><?= htmlspecialchars($filmDetails->titre_film, ENT_QUOTES, 'UTF-8'); ?>
                        <?php if (isset($_SESSION['username'])): ?>

                            <a href="modif.php?titre=<?= urlencode($filmDetails->num_film) ?>" class="stylo">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-pencil-fill" viewBox="0 0 16 16" class="stylo">
                                    <path
                                        d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z" />
                                </svg>
                            </a>
                        <?php endif; ?>

                    </h1>

                    <h4><?= htmlspecialchars($filmDetails->anSortie_film, ENT_QUOTES, 'UTF-8'); ?>
                        <?php if (isset($_SESSION['username'])): ?>
                            <a href="modif.php?annee=<?= urlencode($filmDetails->num_film) ?>" class="stylo">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z" />
                                </svg>
                            </a>
                        <?php endif; ?>
                    </h4>



                    <h4><?= htmlspecialchars($filmDetails->synopsis, ENT_QUOTES, 'UTF-8'); ?>
                        <?php if (isset($_SESSION['username'])): ?>

                            <a href="modif.php?synopsis=<?= urlencode($filmDetails->num_film) ?>" class="stylo">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z" />
                                </svg>
                            </a>
                        <?php endif; ?>

                    </h4>
                    <h4><?= htmlspecialchars(implode(" | ", $filmDetails->getTagsNames()), ENT_QUOTES, 'UTF-8'); ?>
                        <?php if (isset($_SESSION['username'])): ?>
                            <a href="modif.php?tag=<?= urlencode($filmDetails->num_film) ?>" class="stylo">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z" />
                                </svg>
                            </a>
                        <?php endif; ?>

                    </h4>
                    <div class="icons-movie">
                        <svg id="add-icon-<?= $filmDetails->num_film ?>" title="Ajouter à la liste"
                            xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor"
                            class="bi add-test" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2" />
                        </svg>
           
                        <?php if ($filmDetails->est_regarde == 0): ?>
                            <svg id="not-seen-icon-<?= $filmDetails->num_film ?>" xmlns="http://www.w3.org/2000/svg" width="50"
                                height="50" fill="currentColor" class="bi2" viewBox="0 0 16 16">
                                <path
                                    d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7 7 0 0 0-2.79.588l.77.771A6 6 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755q-.247.248-.517.486z" />
                                <path
                                    d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829" />
                                <path
                                    d="M3.35 5.47q-.27.24-.518.487A13 13 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7 7 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12z" />
                            </svg>

                        <?php else: ?>

                            <svg id="seen-icon-<?= $filmDetails->num_film ?>" xmlns="http://www.w3.org/2000/svg" width="50"
                                height="50" fill="currentColor" class="bi2" viewBox="0 0 16 16">
                                <path
                                    d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                <path
                                    d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                            </svg>

                        <?php endif; ?>
                        <?php if (isset($_SESSION['username'])): ?>
                            <svg id="delete-icon-<?= $filmDetails->titre_film ?>" xmlns="http://www.w3.org/2000/svg" width="50"
                                height="50" fill="currentColor" class="bi delete-test" viewBox="0 0 16 16">
                                <path
                                    d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                            </svg>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="infoMovie2">
                    <div class="cat1">
                        <a class="titreSousImage"href="realisateur.php?nom_real=<?= urlencode(htmlspecialchars($filmDetails->getNomReal(), ENT_QUOTES, 'UTF-8')) ?>">
                            <span><?= htmlspecialchars($filmDetails->getNomReal(), ENT_QUOTES, 'UTF-8'); ?>
                        </a>
                            <?php if (isset($_SESSION['username'])): ?>
                                <a href="modif.php?realName=<?= urlencode($filmDetails->num_film) ?>" class="stylo">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z" />
                                    </svg>
                                </a>
                            <?php endif; ?>
                        </span>
                        <div class="image-ra">
                            <a class="titreSousImage"href="realisateur.php?nom_real=<?= urlencode(htmlspecialchars($filmDetails->getNomReal(), ENT_QUOTES, 'UTF-8')) ?>">
                                <img src="<?= "../images/realisateurs/" . htmlspecialchars($filmDetails->getNomImgReal(), ENT_QUOTES, 'UTF-8') ?>" alt="Réalisateur">
                            </a>
                        <?php if (isset($_SESSION['username'])): ?>
                            
                            <a href="modif.php?image=<?= urlencode($filmDetails->num_film) ?>" class="stylo overlay">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z" />
                                </svg>
                            </a>
                        <?php endif; ?>
                        </div>
                    </div>


                </div>
            </div>
            <div class="film-categorie">
                <span class="acteur-film">Acteurs
                    <?php if (isset($_SESSION['username'])): ?>
                        <a href="add_acteur.php?num_film=<?= htmlspecialchars($filmDetails->num_film, ENT_QUOTES, 'UTF-8'); ?>"
                            class="btn btn-primary">Ajouter des acteurs ></a>
                    <?php endif; ?>
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
                                <a class="titreSousImage"href="acteur.php?nom_act=<?= urlencode($actor->nom_act) ?>">
                                    <img src="<?= "../images/acteurs/" . $actor->nom_img ?>" alt="<?= htmlspecialchars($actor->nom_act, ENT_QUOTES, 'UTF-8'); ?>">
                                    <span><?= htmlspecialchars($actor->nom_act, ENT_QUOTES, 'UTF-8'); ?></span>
                                </a>
                                <?php if (isset($_SESSION['username'])): ?>
                                    <svg id="delete-icon-<?= $num_act ?>" xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                        fill="currentColor" class="bi bi-trash3 hidden c" viewBox="0 0 16 16">
                                        <path
                                            d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                                    </svg>
                                <?php endif; ?>
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
    // Gérer la suppression des acteurs
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.c').forEach(icon => {
        icon.addEventListener('click', function () {
            let actorId = this.id.replace('delete-icon-', '');
            deleteActor(actorId);
        });
    });
});

// Gérer la suppression des films
document.addEventListener('DOMContentLoaded', function () {
    let deleteIcon = document.querySelector('.delete-test');
    deleteIcon.addEventListener('click', function () {
        let filmTitle = this.id.replace('delete-icon-', '');
        deleteFilm(filmTitle);
    });
});

// Gérer l'ajout de films à la watchlist
document.addEventListener('DOMContentLoaded', function () {
    let addIcon = document.querySelector('.add-test');
    console.log(addIcon);
    addIcon.addEventListener('click', function () {
        let filmTitle = this.id.replace('add-icon-', '');
        console.log(filmTitle);
        addFilmToWatchlist(filmTitle);
    });
});

// Gérer la mise à jour du statut d'un film
document.addEventListener('DOMContentLoaded', function () {
    let seeIcon = document.querySelector('.bi2');
    seeIcon.addEventListener('click', function () {
        let filmNum = this.id.split('-').pop();
        console.log(filmNum);
        updateFilmStatus(filmNum);
    });
});

    function deleteActor(actorId) {
        let filmId = <?= json_encode($num_film) ?>;
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

    function deleteFilm(filmTitle) {
        fetch('supprimer_film.php?id=' + filmTitle, {
            method: 'GET'
        })
            .then(response => {
                if (response.ok) {
                    window.location.reload();
                } else {
                    console.error('Erreur lors de la suppression du film');
                }
            })
            .catch(error => {
                console.error('Erreur lors de la suppression du film :', error);
            });
    }

    function addFilmToWatchlist(filmTitle) {
        fetch('ajouter_film_liste.php?id=' + filmTitle, {
            method: 'GET'
        })
            .then(response => {
                if (response.ok) {
                    window.location.reload();
                } else {
                    console.error('Erreur lors de l\'ajout du film à la watchlist');
                }
            })
            .catch(error => {
                console.error('Erreur lors de l\'ajout du film à la watchlist :', error);
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

    function closeFilter() {
        let filterForm = document.querySelector(".filter-form");
        let computedStyle = window.getComputedStyle(filterForm);
        if (computedStyle.display === "flex") {
            filterForm.style.display = "none";
            clearFilterForm();
        }
    }
    function clearFilterForm() {
            let filterInputs = document.querySelectorAll(".filtre-input");
            let filterResults = document.getElementById("filter-results");
            let checkbox = document.getElementById("seen-checkbox");

            filterInputs.forEach(input => {
                input.value = "";
            });
            filterResults.innerHTML = "";
            checkbox.checked = false;
        }
        document.addEventListener("DOMContentLoaded", function () {
    let filterForm = document.querySelector(".filter-form");
    let closeButton = document.querySelector(".bi-x-circle-filter");
    let filterIcon = document.querySelector("#filter-icon");

    if (closeButton) {
        closeButton.addEventListener("click", closeFilter);
    }

    if (filterIcon) {
        filterIcon.addEventListener("click", openFilter);
    }

    function openFilter() {
        let computedStyle = window.getComputedStyle(filterForm);
        if (computedStyle.display === "none") {
            filterForm.style.display = "flex";
        }
    }

    function closeFilter() {
        let computedStyle = window.getComputedStyle(filterForm);
        if (computedStyle.display === "flex") {
            filterForm.style.display = "none";
            clearFilterForm();
        }
    }

    function clearFilterForm() {
        let filterInputs = document.querySelectorAll(".filtre-input");
        let filterResults = document.getElementById("filter-results");
        let checkbox = document.getElementById("seen-checkbox");

        filterInputs.forEach(input => {
            input.value = "";
        });
        filterResults.innerHTML = "";
        checkbox.checked = false;
    }

    filterForm.addEventListener("submit", function (event) {
        event.preventDefault();
        let filters = {
            year: document.getElementById("year-input").value,
            genre: document.getElementById("genre-input").value,
            realisateur: document.getElementById("realisateur-input").value,
            acteur: document.getElementById("acteur-input").value,
            seen: document.getElementById("seen-checkbox").checked ? 1 : 0
        };
        filterFilms(filters);
    });

    function filterFilms(filters) {
        let url = "search_filtre.php";
        let params = new URLSearchParams(filters).toString();
        let requestUrl = url + "?" + params;

        fetch(requestUrl)
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error("Network response was not ok");
                }
            })
            .then(data => {
                displayFilterResults(data);
            })
            .catch(error => {
                console.error("Error:", error);
            });
    }

    function displayFilterResults(results) {
        let filterResultsContainer = document.getElementById("filter-results");
        filterResultsContainer.innerHTML = "";

        if (results.length > 0) {
            results.forEach(result => {
                let subContainer = document.createElement("a");
                subContainer.classList.add("sub-container-row");
                subContainer.href = "movies.php?nom_film=" + encodeURIComponent(result.titre_film);

                let resultItem = document.createElement("div");
                resultItem.classList.add("sub-container-movie-info");
                resultItem.innerHTML =
                    `<div>${result.titre_film}</div>
                     <div>${result.anSortie_film}</div>
                     <div>${result.genre_film}</div>`;

                let imgResult = document.createElement("img");
                imgResult.src = "../images/affiches/" + result.nom_affiche;

                subContainer.appendChild(imgResult);
                subContainer.appendChild(resultItem);
                filterResultsContainer.appendChild(subContainer);
            });
        } else {
            let noResultsMessage = document.createElement("div");
            noResultsMessage.textContent = "Aucun film trouvé pour ces critères.";
            filterResultsContainer.appendChild(noResultsMessage);
        }
        filterResultsContainer.classList.add("visible");
    }

    let filterInputs = document.querySelectorAll(".filtre-input");
    let checkbox = document.getElementById("seen-checkbox");

    filterInputs.forEach(input => {
        input.addEventListener("input", function () {
            let filters = {
                year: document.getElementById("year-input").value,
                genre: document.getElementById("genre-input").value,
                realisateur: document.getElementById("realisateur-input").value,
                acteur: document.getElementById("acteur-input").value,
                seen: checkbox.checked ? 1 : 0
            };
            filterFilms(filters);
        });
    });

    checkbox.addEventListener("change", function () {
        let filters = {
            year: document.getElementById("year-input").value,
            genre: document.getElementById("genre-input").value,
            realisateur: document.getElementById("realisateur-input").value,
            acteur: document.getElementById("acteur-input").value,
            seen: checkbox.checked ? 1 : 0
        };
        filterFilms(filters);
    });
});

    let menuIcon = document.querySelector(".fa-bars");
    let closeIcon = document.querySelector(".fa-xmark");
    let searchIcon = document.querySelector(".bi-search");
    let circle = document.querySelector(".bi-x-circle");
    let carousels = document.querySelectorAll(".carousel-container");

    if (menuIcon) {
        menuIcon.addEventListener("click", openMenu);
    }

    if (closeIcon) {
        closeIcon.addEventListener("click", closeMenu);
    }

    if (searchIcon) {
        searchIcon.addEventListener("click", openSearch);
    }

    if (circle) {
        circle.addEventListener("click", closeSearch);
    }

    carousels.forEach((carousel) => {
        let leftArrow = carousel.querySelector(".left-arrow");
        let rightArrow = carousel.querySelector(".right-arrow");
        let films = carousel.querySelector(".films");

        leftArrow.addEventListener("click", () => scrollLeft(films));
        rightArrow.addEventListener("click", () => scrollRight(films));
        films.addEventListener("scroll", () => checkArrowVisibility(carousel));
        checkArrowVisibility(carousel);
    });

    function checkArrowVisibility(carousel) {
        let films = carousel.querySelector(".films");
        let leftArrow = carousel.querySelector(".left-arrow");
        let rightArrow = carousel.querySelector(".right-arrow");

        if (films.scrollLeft === 0) {
            leftArrow.classList.add("arrow-hidden");
        } else {
            leftArrow.classList.remove("arrow-hidden");
        }

        if (films.scrollLeft + films.clientWidth >= films.scrollWidth) {
            rightArrow.classList.add("arrow-hidden");
        } else {
            rightArrow.classList.remove("arrow-hidden");
        }
    }

    function openMenu() {
        let sideMenu = document.getElementById("sidemenu");
        sideMenu.style.right = "0";
    }

    function closeMenu() {
        let sideMenu = document.getElementById("sidemenu");
        sideMenu.style.right = "-200px";
    }

    function openSearch() {
        let searchForm = document.querySelector(".search-form");
        let computedStyle = window.getComputedStyle(searchForm);

        if (computedStyle.display === "none") {
            searchForm.style.display = "flex";
        }
    }

    function closeSearch() {
        let searchForm = document.querySelector(".search-form");
        let computedStyle = window.getComputedStyle(searchForm);
        let searchInput = document.getElementById("search-input");
        let searchResult = document.getElementById("search-results");

        if (computedStyle.display === "flex") {
            searchForm.style.display = "none";
            searchInput.value = "";
            searchResult.innerHTML = "";
            closeFilter();
        }
    }


    function scrollLeft(films) {
        films.scrollBy({
            left: -280 * 3,
            behavior: "smooth",
        });
    }

    function scrollRight(films) {
        films.scrollBy({
            left: 280 * 3,
            behavior: "smooth",
        });
    }

    let searchForm = document.querySelector(".search-form");
    let searchInput = document.getElementById("search-input");


    let Timer;
    let Delay = 300;

    searchInput.addEventListener("input", function () {
        clearTimeout(Timer);
        Timer = setTimeout(function () {
            searchFilms(searchInput.value);
        }, Delay);
    });

    // Fonction de recherche de films
    function searchFilms(searchInput) {
        // Construction de l'URL de recherche
        let url = "search.php";
        let params = "?query=" + encodeURIComponent(searchInput);
        let request = url + params;

        // Requête fetch
        fetch(request)
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error("Network response was not ok");
                }
            })
            .then(data => {
                displaySearchResults(data);
            })
            .catch(error => {
                console.error("Error:", error);
            });
    }

    // Fonction pour afficher les résultats de la recherche
    function displaySearchResults(results) {
        let searchResultsContainer = document.getElementById("search-results");
        searchResultsContainer.innerHTML = "";

        if (results.length > 0) {
            results.forEach(result => {
                console.log(result)
                let subContainer = document.createElement("a");
                subContainer.classList.add("sub-container-row");
                subContainer.href = "movies.php?nom_film=" + encodeURIComponent(result.titre_film); let resultItem = document.createElement("div");
                resultItem.classList.add("sub-container-movie-info");
                resultItem.innerHTML =
                    "<div>" +
                    result.titre_film +
                    "</div> <div>" +
                    result.anSortie_film +
                    "</div> <div>" +
                    result.genre +
                    "</div>";
                let imgResult = document.createElement("img");
                imgResult.src = "../images/affiches/" + result.img_film;

                subContainer.appendChild(imgResult);
                subContainer.appendChild(resultItem);
                searchResultsContainer.appendChild(subContainer);
            });
        } else {
            let noResultsMessage = document.createElement("div");
            noResultsMessage.textContent = "Aucun résultat trouvé.";
            searchResultsContainer.appendChild(noResultsMessage);
        }
        searchResultsContainer.classList.add("visible");
    }

</script>

<?php $content = ob_get_clean() ?>
<?php Template_movie::render($content) ?>