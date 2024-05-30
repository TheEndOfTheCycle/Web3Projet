
<?php
require_once "../config.php";

require ".." . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'Autoloader.php';
Autoloader::register();
session_start();

?>

<!-- Démarre le buffering -->
<?php ob_start() ?>

<div class="background">
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
                                if(isset($_SESSION['username'])) {
                                    // Utilisateur connecté, affiche le lien de déconnexion
                                    echo '<li><a href="logout.php">Déconnexion Admin</a></li>';
                                } else {
                                    // Utilisateur non connecté, affiche le lien de connexion
                                    echo '<li><a href="logging.php">Connexion Admin</a></li>';
                                }
                            ?>
                            <li id="search-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-search" viewBox="0 0 16 16" 0>
                                    <path
                                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                                </svg></li>
                            <i class="fa-solid fa-xmark"></i>
                        </ul>
                        <i class="fa-solid fa-bars"></i>
                    </nav>
                </div>
            </div>
            <form class="search-form">
                <div class="searche-bar">
                    <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-search" viewBox="0 0 16 16">
                            <path
                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                        </svg>
                    </span>
                    <input type="text" id="search-input" placeholder="Rechercher...">
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor"
                    class="bi bi-x-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                    <path
                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                </svg>
            </form>
        </header>

        <div class="container-movie">
            <div class="infoMovie1">
                <div class="infoMovie2">
                    <h1>Oppenheimer</h1>
                    <h4>2023</h4>
                    <h4>En 1942, convaincus que l’Allemagne nazie est en train de développer une arme nucléaire, les
                        États-Unis initient, dans le plus grand secret, le "Projet Manhattan" destiné à mettre au point
                        la première bombe atomique de l’histoire. Pour piloter ce dispositif, le gouvernement engage J.
                        Robert Oppenheimer, brillant physicien, qui sera bientôt surnommé "le père de la bombe
                        atomique". C’est dans le laboratoire ultra-secret de Los Alamos, au cœur du désert du
                        Nouveau-Mexique, que le scientifique et son équipe mettent au point une arme révolutionnaire
                        dont les conséquences, vertigineuses, continuent de peser sur le monde actuel…
                    </h4>

                    <h4> Biopic | Drame | Historique</h4>
                    <div class="icons-movie">
                        <svg id="add-icon" title="Ajouter à la liste" xmlns="http://www.w3.org/2000/svg" width="50"
                            height="50" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2" />
                        </svg>
                        <div class="icons-movie-toggle">
                            <svg id="seen-icon" title="Déjà vu" xmlns="http://www.w3.org/2000/svg" width="50"
                                height="50" fill="currentColor" class="bi bi-eye hide-icon" viewBox="0 0 16 16">
                                <path
                                    d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                <path
                                    d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                            </svg>
                            <svg id="not-seen-icon" title="Non vu" xmlns="http://www.w3.org/2000/svg" width="50"
                                height="50" fill="currentColor" class="bi bi-eye-slash" viewBox="0 0 16 16">
                                <path
                                    d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7 7 0 0 0-2.79.588l.77.771A6 6 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755q-.247.248-.517.486z" />
                                <path
                                    d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829" />
                                <path
                                    d="M3.35 5.47q-.27.24-.518.487A13 13 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7 7 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12z" />
                            </svg>
                        </div>



                    </div>


                </div>
                <div class="infoMovie2">
                    <div class="cat1">
                        <span>Realisateur</span>
                        <img src="../images/cillian.jpg">
                        <span>Cillian Murphy</span>
                    </div>
                </div>
            </div>
            <div class="film-categorie">
                <span class="film-categorie-name">Acteurs</span>
                <div class="carousel-container">
                    <div class="carousel-arrow left-arrow">&#10094;</div>

                    <div class="films">

                        <div class="acteur-scroll">
                            <img src="../images/cillian.jpg" alt="Cillian">
                            <span>Cillian Murphy</span>

                        </div>
                        <div class="acteur-scroll">
                            <img src="../images/cillian.jpg" alt="Cillian">
                            <span>Cillian Murphy</span>
                        </div>
                        <div class="acteur-scroll">
                            <img src="../images/cillian.jpg" alt="Cillian">
                            <span>Cillian Murphy</span>
                        </div>
                        <div class="acteur-scroll">
                            <img src="../images/cillian.jpg" alt="Cillian">
                            <span>Cillian Murphy</span>
                        </div>
                        <div class="acteur-scroll">
                            <img src="../images/cillian.jpg" alt="Cillian">
                            <span>Cillian Murphy</span>
                        </div>
                        <div class="acteur-scroll">
                            <img src="../images/cillian.jpg" alt="Cillian">
                            <span>Cillian Murphy</span>
                        </div>
                        <div class="acteur-scroll">
                            <img src="../images/cillian.jpg" alt="Cillian">
                            <span>Cillian Murphy</span>
                        </div>
                        <div class="acteur-scroll">
                            <img src="../images/cillian.jpg" alt="Cillian">
                            <span>Cillian Murphy</span>
                        </div>
                        <div class="acteur-scroll">
                            <img src="../images/cillian.jpg" alt="Cillian">
                            <span>Cillian Murphy</span>
                        </div>
                        <div class="acteur-scroll">
                            <img src="../images/cillian.jpg" alt="Cillian">
                            <span>Cillian Murphy</span>
                        </div>
                        <div class="acteur-scroll">
                            <img src="../images/cillian.jpg" alt="Cillian">
                            <span>Cillian Murphy</span>
                        </div>
                    </div>
                    <div class="carousel-arrow right-arrow">&#10095;</div>
                </div>
            </div>
        </div>



<!-- Récupère le contenu du buffer (et le vide) -->
<?php $content = ob_get_clean() ?>
<!-- Utilisation du contenu bufferisé -->
<?php Template_movie::render($content) ?>