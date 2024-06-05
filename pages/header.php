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

    <form class="filter-form" action="search_filtre.php" method="get">
    <div class="filter-bar">
    <input type="text" id="year-input" name="year" placeholder="Année">
    <input type="text" id="genre-input" name="genre" placeholder="Genre">
    <input type="text" id="realisateur-input" name="realisateur" placeholder="Realisateur">
    <input type="text" id="acteur-input" name="acteur" placeholder="acteur">
    <div class="checkbox-container">
        <label for="seen-checkbox">Vu</label>
        <input type="checkbox" id="seen-checkbox" name="seen">
    </div>
    <button type="submit" class="filter-button">Filtrer</button>
</div>

</form>
    <div id="search-results"></div>
</form>

</header>