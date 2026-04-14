let errorMsg = document.querySelector("p#error-msg");

/*
 * Lorsque la page est chargée
 * Lance la requête API et met à jour la weather card
 */
window.onload = function () {
  const latitude = pageData["latitude"];
  const longitude = pageData["longitude"];
  let URL = `https://api.open-meteo.com/v1/forecast?latitude=${latitude}&longitude=${longitude}&hourly=temperature_2m,uv_index,wind_speed_10m,precipitation_probability,cloud_cover&timezone=Europe%2FBerlin&forecast_days=1`;
  // === Requête API
  fetch(URL)
    .then((response) => response.json()) // récupère la data json de la réponse
    .then((response) => display(response)) // envoie la data dans la fonction de màj du graphique
    .catch((error) => {
      const msg = "Erreur de chargement de la météo, réessayez plus tard.";
      document.getElementById("error-msg").textContent = msg;

      console.log("Erreur météo : " + error);
    });
};

/*
 * Fonction display
 * Met à jour le graphique en remplaçant les données avec les nouvelles données renvoyées par l'API
 * paramètre : prend la data donnée par l'API
 * résultat : met à jour le graphique avec la nouvelle data
 */
function display(data) {
  // Détermine l'heure actuelle en format ISO
  const now = new Date();
  const currentHour = now.toISOString().slice(0, 13); // "2026-04-13T10"

  // Trouve l'index des données API correspondant à l'heure actuelle
  const index = data.hourly.time.findIndex((time) =>
    time.startsWith(currentHour),
  );

  const temperature = data.hourly.temperature_2m[index];
  const wind = data.hourly.wind_speed_10m[index];
  const rain = data.hourly.precipitation_probability[index];
  const uv = data.hourly.uv_index[index];
  const cloud = data.hourly.cloud_cover[index];
  console.log(data);
  document.querySelector("#temp").textContent = temperature + "°C";
  document.querySelector("#wind").textContent = wind + "km/h";
  document.querySelector("#rain").textContent = rain + "%";
  document.querySelector("#uv").textContent = uv;
  document.querySelector("#cloud").textContent = cloud + "%";
}
