/*
 * Script pour afficher la note choisie par l'utilisateur
 */

const stars = document.querySelectorAll("#rating i");
const note = pageData["note"];

// Colorie l'étoile choisie et les étoiles précédentes
stars.forEach((star) => {
  const value = Number(star.getAttribute("data-value"));

  if (value <= note) {
    star.classList.add("active");
    star.classList.remove("fa-regular");
    star.classList.add("fa-solid");
  } else {
    star.classList.remove("active");
    star.classList.remove("fa-solid");
    star.classList.add("fa-regular");
  }
});
