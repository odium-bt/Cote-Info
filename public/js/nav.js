const burger = document.getElementById("burger");
const nav = document.getElementById("header-nav");
// Ajoute la classe active à #header-nav lorsque l'utilisateur clique sur #burger
burger.addEventListener("click", () => {
  nav.classList.toggle("active");
});
