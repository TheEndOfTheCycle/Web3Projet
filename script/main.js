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

    if (computedStyle.display === "flex") {
      searchForm.style.display = "none";
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

  // Capture de l'événement de soumission du formulaire de recherche
  let searchForm = document.querySelector(".search-form");
  searchForm.addEventListener("submit", function (event) {
    event.preventDefault(); // Empêcher le comportement par défaut du formulaire
    let searchInput = document.getElementById("search-input").value;
    performSearch(searchInput);
  });

  // Fonction pour effectuer la recherche
  function performSearch(query) {
    // Effectuer une requête AJAX pour envoyer le terme de recherche à search.php
    fetch("search.php?query=" + encodeURIComponent(query))
      .then((response) => {
        // Vérifier si la requête a réussi
        if (!response.ok) {
          throw new Error("Network response was not ok");
        }
        // Convertir la réponse en JSON

        return response.json();
      })
      .then((data) => {
        // Vérifier s'il y a une erreur dans la réponse
        if (data.error) {
          console.error("Error:", data.error);
          displaySearchResults([]); // Afficher un message "Aucun résultat trouvé"
        } else {
          // Afficher les résultats dans la page
          console.log(data);

          displaySearchResults(data);
        }
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  }

  // Fonction pour afficher les résultats de la recherche
  function displaySearchResults(results) {
    // Sélectionner le conteneur où les résultats seront affichés
    let searchResultsContainer = document.getElementById("search-results");

    // Effacer les résultats précédents
    searchResultsContainer.innerHTML = "";

    // Vérifier s'il y a des résultats
    if (results.length > 0) {
      // Parcourir les résultats et les afficher dans la page
      results.forEach((result) => {
        let subContainer = document.createElement("div");
        let resultItem = document.createElement("div");
        let imgResult = document.createElement("img");
        subContainer.classList.add("sub-container-row");
        resultItem.innerHTML =
          "<div class= sub-container-movie-info>" +
          "<div>" +
          result.titre_film +
          "</div> <div>" +
          result.anSortie_film +
          "</div> <div>" +
          result.genre_film +
          "</div> </div>";
        imgResult.src = "../images/affiches/" + result.img_film;
        console.log(resultItem);
        subContainer.appendChild(imgResult);
        subContainer.appendChild(resultItem);

        searchResultsContainer.appendChild(subContainer);
      });
    } else {
      // Aucun résultat trouvé
      let noResultsMessage = document.createElement("div");
      noResultsMessage.textContent = "Aucun résultat trouvé.";
      searchResultsContainer.appendChild(noResultsMessage);
    }
    searchResultsContainer.classList.add("visible");
  }
});
