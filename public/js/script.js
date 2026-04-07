/*
 * Script pour ma carte interactive
 * Fonctionnalités :
 * - Boutons
 * - Zoom sur les régions
 * - Affichage des noms des stations balnéaires
 * - Affichage d'infos dynamiques sur la carte (bonus)
 */

/*
 * Function zoomRegion()
 * paramètre : id de la région visée
 * résultat : zoom sur cette région
 */
function zoomRegion(regionId) {
  const svg = document.getElementById("svgmap"); // élément DOM de la carte
  const region = document.getElementById(regionId); // id de la région sur laquelle zoomer
  const bbox = region.getBBox(); // get BBox = obtiens la bounding box de la région sélectionnée

  // définie le padding autour de la région sur laquelle on zoom
  const padding = 20;

  // target X/Y = x/y de la bbox - le padding
  const targetX = bbox.x - padding;
  const targetY = bbox.y - padding;
  // largeur et hauter = largeur/hauteur de la région + padding * 2
  const targetWidth = bbox.width + padding * 2;
  const targetHeight = bbox.height + padding * 2;

  // Cache les boutons régionaux
  const regions = document.querySelectorAll(".region-btn");
  regions.forEach((button) => {
    button.classList.add("hide");
  });

  // appelle la fonction d'animation du zoom
  animateViewBox(svg, targetX, targetY, targetWidth, targetHeight, 600); // modifier le temps pour changer la vitesse de l'animation
}

/*
 * Fonction animateViewBox
 * paramètres : svg = élément DOM de la carte
 *              targetX, targetY, targetWidth, targetHeight = dimensions cibles du zoom
 *              duration = durée de l'animation
 */
function animateViewBox(
  svg,
  targetX,
  targetY,
  targetWidth,
  targetHeight,
  duration,
) {
  const startViewBox = svg.getAttribute("viewBox").split(" ").map(Number);
  const startX = startViewBox[0];
  const startY = startViewBox[1];
  const startWidth = startViewBox[2];
  const startHeight = startViewBox[3];

  const startTime = performance.now();

  function animate(currentTime) {
    const elapsed = currentTime - startTime;
    const progress = Math.min(elapsed / duration, 1);

    // Interpolation linéaire
    const currentX = startX + (targetX - startX) * progress;
    const currentY = startY + (targetY - startY) * progress;
    const currentWidth = startWidth + (targetWidth - startWidth) * progress;
    const currentHeight = startHeight + (targetHeight - startHeight) * progress;

    svg.setAttribute(
      "viewBox",
      `${currentX} ${currentY} ${currentWidth} ${currentHeight}`,
    );

    if (progress < 1) {
      requestAnimationFrame(animate);
    }
  }

  requestAnimationFrame(animate);
}

/*
 * Function zoomRegion()
 * paramètre : /
 * résultat : Affiche la carte entière
 */
function resetZoom() {
  const svg = document.getElementById("svgmap");
  animateViewBox(svg, 0, 5.65, 869.53302, 857.7724, 500);

  // Affiche les boutons régionaux
  const regions = document.querySelectorAll(".region-btn");
  regions.forEach((button) => {
    button.classList.remove("hide");
  });
}

/*
 * Function loadBeaches
 * paramètre : id de la région
 * résultat : Affiche les stations balnéaires de la région
 */
function loadBeaches(regionId) {
  fetch().then().then();
}
