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

<script>
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