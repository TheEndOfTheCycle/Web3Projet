document.addEventListener("DOMContentLoaded", function () {
    let seenIcon = document.getElementById("seen-icon");
    let notSeenIcon = document.getElementById("not-seen-icon");

    // Initialement cacher seenIcon
    seenIcon.classList.add("hide-icon");
    notSeenIcon.classList.remove("hide-icon");

    seenIcon.addEventListener("click", function () {
        toggleIcons(seenIcon, notSeenIcon);
    });

    notSeenIcon.addEventListener("click", function () {
        toggleIcons(notSeenIcon, seenIcon);
    });

    function toggleIcons(iconToHide, iconToShow) {
        iconToHide.classList.add("hide-icon");
        iconToShow.classList.remove("hide-icon");
    }

})