document.addEventListener("DOMContentLoaded", function () {
    let menuIcon = document.querySelector('.fa-bars');
    let closeIcon = document.querySelector('.fa-xmark');
    let searchIcon = document.querySelector('.bi-search');
    let circle = document.querySelector('.bi-x-circle');
    let carousels = document.querySelectorAll('.carousel-container');

    if (menuIcon) {
        menuIcon.addEventListener('click', openMenu);
    }

    if (closeIcon) {
        closeIcon.addEventListener('click', closeMenu);
    }

    if (searchIcon) {
        searchIcon.addEventListener('click', openSearch);
    }

    if (circle) {
        circle.addEventListener("click", closeSearch);
    }

    carousels.forEach(carousel => {
        let leftArrow = carousel.querySelector('.left-arrow');
        let rightArrow = carousel.querySelector('.right-arrow');
        let films = carousel.querySelector('.films');

        leftArrow.addEventListener('click', () => scrollLeft(films));
        rightArrow.addEventListener('click', () => scrollRight(films));
        films.addEventListener('scroll', () => checkArrowVisibility(carousel));
        checkArrowVisibility(carousel); 
    });

    function checkArrowVisibility(carousel) {
        let films = carousel.querySelector('.films');
        let leftArrow = carousel.querySelector('.left-arrow');
        let rightArrow = carousel.querySelector('.right-arrow');

        // Masquer la flèche gauche si on est au début
        if (films.scrollLeft === 0) {
            leftArrow.classList.add('arrow-hidden');
        } else {
            leftArrow.classList.remove('arrow-hidden');
        }

        // Masquer la flèche droite si on est à la fin
        if (films.scrollLeft + films.clientWidth >= films.scrollWidth) {
            rightArrow.classList.add('arrow-hidden');
        } else {
            rightArrow.classList.remove('arrow-hidden');
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
        let searchForm = document.querySelector('.search-form');
        let computedStyle = window.getComputedStyle(searchForm);

        if (computedStyle.display === 'none') {
            searchForm.style.display = 'flex';
        }
    }

    function closeSearch() {
        let searchForm = document.querySelector('.search-form');
        let computedStyle = window.getComputedStyle(searchForm);

        if (computedStyle.display === 'flex') {
            searchForm.style.display = 'none';
        }
    }

    function scrollLeft(films) {
        films.scrollBy({
            left: -280 * 3,
            behavior: 'smooth'
        });
    }

    function scrollRight(films) {
        films.scrollBy({
            left: 280 * 3,
            behavior: 'smooth'
        });
    }
});
