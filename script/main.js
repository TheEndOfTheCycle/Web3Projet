document.addEventListener("DOMContentLoaded", function() {
    let menuIcon = document.querySelector('.fa-bars');
    let closeIcon = document.querySelector('.fa-xmark');
    let searchIcon = document.querySelector('.bi-search');
    let circle = document.querySelector('.bi-x-circle');

    if (menuIcon) {
        menuIcon.addEventListener('click', openmenu);
    }

    if (closeIcon) {
        closeIcon.addEventListener('click', closemenu);
    }

    if (searchIcon) {
        searchIcon.addEventListener('click', openSearch);
    }
    if(circle){
        circle.addEventListener("click", closeSearch)
    }
});

function openmenu() {
    let sidemenu = document.getElementById("sidemenu");
    sidemenu.style.right = "0";
}

function closemenu() {
    let sidemenu = document.getElementById("sidemenu");
    sidemenu.style.right = "-200px";
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


