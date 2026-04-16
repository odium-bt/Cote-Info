/*
 * Script permettant la notation des stations par les utilisateurs
 */

const stars = document.querySelectorAll("#rating i");
const input = document.getElementById("rating-value");

stars.forEach((star) => {
  star.addEventListener("click", () => {
    const value = star.getAttribute("data-value");

    input.value = value; // La note choisie

    // Colorie l'étoile choisie et les étoiles précédentes
    stars.forEach((star) => {
      if (star.getAttribute("data-value") <= value) {
        star.classList.add("active");
        star.classList.remove("fa-regular");
        star.classList.add("fa-solid");
      } else {
        star.classList.remove("active");
        star.classList.remove("fa-solid");
        star.classList.add("fa-regular");
      }
    });
  });
});
