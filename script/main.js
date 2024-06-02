document.addEventListener("DOMContentLoaded", function () {
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
  searchForm.addEventListener("submit", function (event) {
    event.preventDefault(); // Empêcher le comportement par défaut du formulaire
    let searchInput = document.getElementById("search-input").value;
    searchFilms(searchInput);
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
                let subContainer = document.createElement("div");
                subContainer.classList.add("sub-container-row");
                let resultItem = document.createElement("div");
                resultItem.classList.add("sub-container-movie-info");
                resultItem.innerHTML =
                    "<div>" +
                    result.titre_film +
                    "</div> <div>" +
                    result.anSortie_film +
                    "</div> <div>" +
                    result.genre_film +
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

   


});
