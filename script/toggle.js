document.addEventListener("DOMContentLoaded", function () {
    let iconPairs = document.querySelectorAll(".icons-movie");
  
    iconPairs.forEach((pair) => {
      const seenIcon = pair.querySelector(".bi1");
      const notSeenIcon = pair.querySelector(".bi2");
  
      // Initialement, cacher l'icône de non-visionnage
      notSeenIcon.classList.remove("hide-icon");
      seenIcon.classList.add("hide-icon");
  
      seenIcon.addEventListener("click", () => {
        toggleIcons(seenIcon, notSeenIcon);
      });
  
      notSeenIcon.addEventListener("click", () => {
        toggleIcons(notSeenIcon, seenIcon);
      });
    });
  
    function toggleIcons(iconToHide, iconToShow) {
      iconToHide.classList.add("hide-icon");
      iconToShow.classList.remove("hide-icon");
    }
  });