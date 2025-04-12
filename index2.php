<!DOCTYPE html>
<html lang="fr">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>AgroClimate</title>
   <link rel="stylesheet" href="style2.css">
   <link rel="icon" href="photos/logosite.png" type="image/png">
   <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


   <!-- Leaflet CSS et JS -->
   <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
   <script src="https://unpkg.com/leaflet@1.9.1/dist/leaflet.js"></script>
   <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
</head>


<body>
<header>
   <form id="search-form">
      <input type="text" id="searchInput" placeholder="Search..." aria-label="Barre de recherche">
   </form>
   <h1 id="title" style="font-family: 'Arial', sans-serif; font-size: 2.8rem; text-transform: capitalize; letter-spacing: 2px;">
      AgroCLimate <br> 
      <span style="font-size: 1.5rem; color: #333;">Impact du Changement Climatique sur l'Agriculture</span>
   </h1>
</header>
   <style>
   /* Styles pour les feuilles */
   .leaf {
      position: absolute;
      width: 20px;
      height: 20px;
      background: url('https://upload.wikimedia.org/wikipedia/commons/3/36/Leaf_icon.svg') no-repeat center;
      background-size: cover;
      opacity: 0;
      transform: scale(0.5);
      animation: grow-leaf 0.5s forwards;
   }

   /* Animation pour les feuilles */
   @keyframes grow-leaf {
      0% {
         opacity: 0;
         transform: scale(0.5) translate(0, 0);
      }
      100% {
         opacity: 1;
         transform: scale(1) translate(calc(-50px + 100% * var(--x)), calc(-50px + 100% * var(--y)));
      }
   }
</style>

<script>
   const title = document.getElementById("title");

   // Fonction pour générer des feuilles
   function createLeaves() {
      const leafContainer = document.createElement("div");
      leafContainer.style.position = "relative";

      // Créer 4 feuilles
      for (let i = 0; i < 4; i++) {
         const leaf = document.createElement("span");
         leaf.classList.add("leaf");

         // Positionner chaque feuille autour du titre
         leaf.style.setProperty("--x", i === 0 || i === 3 ? -1 : 1); // Gauche ou droite
         leaf.style.setProperty("--y", i === 0 || i === 1 ? -1 : 1); // Haut ou bas

         leafContainer.appendChild(leaf);
      }
      return leafContainer;
   }

   // Ajouter les feuilles lorsque la souris passe sur le titre
   title.addEventListener("mouseover", () => {
      if (!title.querySelector(".leaf")) {
         const leaves = createLeaves();
         title.appendChild(leaves);

         // Retirer les feuilles après une courte durée
         setTimeout(() => {
            leaves.remove();
         }, 1000); // Durée de l'animation
      }
   });
</script>

   <nav class="menu-horizontal">
      <ul>
          <li><a href="actualites.html">Actualités</a></li>
          <li><a href="analyse.php">Analyses</a></li>
          <li><a href="illustrations.html">Visualisations</a></li>
          <li><a href="Predictions.php">Prédictions</a></li>
          <li><a href="interviews.html">Interviews</a></li>
          <li><a href="connexion.php">Se connecter</a></li>
          <li><a href="inscription.php">S'inscrire</a></li>
          
      </ul>

   </nav>

   <section class="main-content">
      <p class="intro-text">"Analyse des effets des variations climatiques sur les cultures et les économies agricoles mondiales."</p>

      <div class="aligned-section">
          <div class="buttons-section">
              <a class="button">Pourquoi c'est important ?</a>
              <a class="button" href="illustrations.html">Visualisations</a>
              <a class="button" href="ourteam.html">Assistance</a>
          </div>

          <p class="main-paragraph">
              "Le changement climatique modifie profondément les conditions agricoles à travers le monde. C'est pourquoi l'impact est significatif sur la production agricole, la biodiversité et l'économie."
          </p>
          <canvas id="myChart" width="400" height="200"></canvas>
      </div>

      <div class="aligned-section"> 
         <img src="photos/climate-change.jpeg" alt="Effets du changement climatique sur l'agriculture" class="content-image">
         <p class="main-paragraph">
            "À travers des statistiques descriptives et des visualisations interactives, nous montrons comment l'augmentation des températures et les événements climatiques extrêmes ont perturbé la production agricole dans plusieurs régions du globe.
            Ces graphiques illustrent clairement les liens entre changement climatique et rendement agricole, soulignant les menaces que cela pose pour la sécurité alimentaire."
         </p>
      </div>

      <div class="aligned-section"> 
          <p class="main-paragraph">
              "Ce projet explore comment le changement climatique affecte les cultures agricoles à travers le monde de 1990 à 2024, en fournissant des recommandations pour une agriculture plus durable."
          </p>

          <div id="map"></div>
          <div id="legend" style="width: 25%; float: right; padding: 10px; font-size: 14px; line-height: 20px; background: #f9f9f9; border: 1px solid #ccc; border-radius: 5px;">
    <!-- La légende sera générée ici -->
</div>
          
<script>
    // Créez la carte et définissez sa vue initiale
    const map = L.map('map').setView([20, 0], 2); // Vue centrée sur le monde

    // Ajoutez la couche de tuiles OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Fonction pour déterminer la couleur en fonction des émissions de CO2
    function getColor(co2) {
        return co2 > 1000 ? '#800026' :
               co2 > 500  ? '#BD0026' :
               co2 > 200  ? '#E31A1C' :
               co2 > 100  ? '#FC4E2A' :
               co2 > 50   ? '#FD8D3C' :
               co2 > 20   ? '#FEB24C' :
               co2 > 10   ? '#FED976' :
                            '#FFEDA0';
    }

    // Fonction pour créer une légende
    function createLegend() {
        const legendDiv = document.getElementById('legend'); // Récupère l'élément div pour la légende
        const grades = [0, 10, 20, 50, 100, 200, 500, 1000]; // Seuils des valeurs
        let labels = '<h4>Émissions de CO2 (MT)</h4>'; // Titre de la légende

        // Génération des blocs de couleurs et valeurs
        for (let i = 0; i < grades.length; i++) {
            labels += `
                <div style="display: flex; align-items: center; margin-bottom: 5px;">
                    <div style="background:${getColor(grades[i] + 1)}; width: 20px; height: 20px; margin-right: 8px;"></div>
                    <span>${grades[i]}${grades[i + 1] ? '&ndash;' + grades[i + 1] : '+'}</span>
                </div>
            `;
        }

        legendDiv.innerHTML = labels; // Injecte le contenu HTML dans la div
    }

    // Récupération des données via fetch
    fetch('getPaysData.php')
        .then(response => response.json())
        .then(data => {
            if (!data || data.error) {
                console.error("Erreur de données :", data.error || "Aucune donnée reçue");
                return;
            }

            // Charger le fichier GeoJSON des pays
            fetch('https://raw.githubusercontent.com/johan/world.geo.json/master/countries.geo.json')
                .then(response => response.json())
                .then(geojsonData => {
                    L.geoJSON(geojsonData, {
                        onEachFeature: function (feature, layer) {
                            // Nom du pays dans le fichier GeoJSON
                            const countryName = feature.properties.name;

                            // Trouver les données correspondantes
                            const countryData = data.find(pays => pays.nom === countryName);

                            if (countryData) {
                                const emissionsCO2 = parseFloat(countryData.EmissionsCO2);

                                // Définir le style en fonction des émissions de CO2
                                layer.setStyle({
                                    fillColor: getColor(emissionsCO2),
                                    weight: 1,
                                    opacity: 1,
                                    color: 'white',
                                    fillOpacity: 0.7
                                });

                                // Ajouter un popup avec les informations
                                layer.bindPopup(`<b>${countryName}</b><br>Émissions de CO2 : ${emissionsCO2} MT`);
                            }
                        }
                    }).addTo(map);
                })
                .catch(error => console.error("Erreur de chargement du GeoJSON :", error));
        })
        .catch(error => console.error("Erreur de récupération des données :", error));

    // Créer et ajouter la légende
    createLegend();
</script>

        </div>

        <p class="conclusion-text">
            "Analyse des Impacts du Changement Climatique sur l'Agriculture : Comprendre les Tendances de 1990 à 2024 pour Informer des Stratégies d'Adaptation et Garantir la Sécurité Alimentaire à Long Terme"
        </p>

        <p class="final-paragraph">
            "Avec une population mondiale en constante croissance, la demande alimentaire ne cesse d'augmenter. Pourtant, les événements climatiques extrêmes réduisent les rendements agricoles et fragilisent les terres cultivables. Comprendre l'impact de ces changements climatiques est crucial pour développer des stratégies d'adaptation et assurer un avenir alimentaire durable."
        </p>
      <footer>
      <p>© 2024 - Tous droits réservés</p>
   </footer>
   </section>

   

   <aside class="sidebar top-sidebar">
      <a href="#">Why trust us</a>
      <a href="ourteam.html">Our team</a>
      <a href="faq.html">FAQ</a>
   </aside>

   <script>
      // Script JavaScript pour gérer la recherche
      document.getElementById('search-form').addEventListener('submit', function(event) {
          event.preventDefault(); // Empêche le rechargement de la page

          const query = document.getElementById('searchInput').value.trim().toLowerCase();

          // page d'actualité
          if (query === "actualité" || query === "actualités" || query === "actualites" || query === "actualite") {
              window.location.href = "actualites.html"; 
          }

          //page d'equipe
          if (query === "équipe" || query === "equipe" || query === "team" || query === "our team") {
              window.location.href = "ourteam.html"; 
          }

          //page d'analyses
          if (query === "analyse" || query === "analyses") {
              window.location.href = "analyse.html"; 
          }

          //page d'illustrations
          if (query === "illustrations" || query === "illustration" || query === "visualisations" || query === "visualisation") {
              window.location.href = "illustrations.html";
          }

          //page de connexion
          if (query === "connexion" || query === "client" || query === "inscription") {
              window.location.href = "connexion.php"; 
          }

          //page d'interviews
          if (query === "interview" || query === "interviews") {
              window.location.href = "interviews.html"; 
          } else {
              alert("Aucune page correspondante trouvée !");
          }
      });
   </script>

<script>
  fetch('getdataindex.php')
    .then(response => response.json())
    .then(data => {
        // Vérification s'il y a une erreur
        if (data.error) {
            console.error("Erreur lors de la récupération des données : ", data.error);
            return;
        }

        // Extraction des indices de santé des sols
        const indicesSanteSols = data.map(item => item.indice_sante_sols);

        // Définition des noms des pays
        const pays = ['France', 'Canada', 'Nigeria', 'Argentina', 'China'];

        // Création du graphique avec les données récupérées
        const ctx = document.getElementById('myChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: pays, // Utiliser les noms des pays
                datasets: [{
                    label: 'Indice de Santé des Sols',
                    data: indicesSanteSols,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            boxWidth: 0 // Retire complètement l'icône dans la légende
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                // Récupérer le nom du pays et la valeur correspondante
                                const pays = context.label; // Nom du pays
                                const valeur = context.raw; // Valeur associée au bâton
                                return `${pays} : ${valeur}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    })
    .catch(error => console.error("Erreur lors du fetch des données : ", error))

</script>

</body>
</html>

