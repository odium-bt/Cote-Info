// Récupère les éléments HTML des boutons et leur ajoute des EventListener("click")
const left = document.querySelector(".left");
const right = document.querySelector(".right");
left.addEventListener("click", previousSlide);
right.addEventListener("click", nextSlide);

// Récupère les éléments slide et l'index de la slide active
const slides = document.querySelectorAll("#slider .slide");
let currentIndex = document
  .querySelector("#slider .slide.active")
  .getAttribute("data-index");

/*
 * Fonction previousSlide
 * paramètres : /
 * résultat : change la slide active à la précédente
 */

function previousSlide() {
  /*
   * Calcul de l'index précédent
   * Le "% slides.length" permet de faire une boucle avec le nombre de slides
   * Si il y a 3 slides :
   * 2 % 3 = 2, 3 % 3 = 0, 4 % 3 = 1...
   * 0 1 2 0 1 2 etc
   */
  const followingIndex = (currentIndex + 1) % slides.length;
  rotateSlide(currentIndex, followingIndex);
}

/*
 * Fonction nextSlide
 * paramètres : /
 * résultat : change la slide active à la suivante
 */
function nextSlide() {
  const followingIndex = (currentIndex - 1 + slides.length) % slides.length;
  rotateSlide(currentIndex, followingIndex);
}

/* Fonction rotateSlide
 * paramètres : index de la slide active, index de la slide suivante
 * résultat : - inverse la classe "active" et "hidden" entre la slide active et la prochaine
 *            - remplace la valeur de currentIndex par l'index de la nouvelle slide active
 */
function rotateSlide(from, to) {
  slides[from].classList.remove("active");
  slides[from].classList.add("hidden");
  slides[to].classList.remove("hidden");
  slides[to].classList.add("active");
  currentIndex = to;
}
