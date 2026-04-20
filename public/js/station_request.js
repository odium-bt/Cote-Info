/*
 * Script servant à trouver les stations liées à la région choisie dans la rédaction d'articles.
 *
 */
document
  .getElementById("region_select")
  .addEventListener("change", function () {
    const regionID = this.value;
    const stationContainer = document.getElementById("station_container");
    const stationList = document.getElementById("station_list");

    if (!regionID) {
      stationContainer.classList.add("hide");
      stationList.innerHTML = "";
      return;
    }

    stationContainer.classList.remove("hide");

    // reset station list
    stationList.innerHTML = "<p>Chargement...</p>";

    fetch(`?action=getStationsByRegion&id_region=${regionID}`)
      .then((response) => response.json())
      .then((data) => {
        display(data);
      })
      .catch((error) => {
        console.error("Erreur:", error);
        stationList.innerHTML = "<p>Erreur de chargement</p>";
      });
  });

function display(data) {
  const stationList = document.getElementById("station_list");
  stationList.innerHTML = "";

  data.forEach((station) => {
    const label = document.createElement("label");
    const checkbox = document.createElement("input");
    checkbox.type = "checkbox";
    checkbox.name = "stations[]";
    checkbox.value = station.id_station;

    label.appendChild(checkbox);
    label.appendChild(document.createTextNode(" " + station.label));
    stationList.appendChild(label);
  });
}
