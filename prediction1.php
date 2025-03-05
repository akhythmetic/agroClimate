<!DOCTYPE html>
<html lang="fr">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Prédictions Agricoles</title>
   <link rel="stylesheet" href="style2.css">
   <link rel="icon" href="photos/logosite.png" type="image/png">
   <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


   <!-- Leaflet CSS et JS -->
   <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
   <script src="https://unpkg.com/leaflet@1.9.1/dist/leaflet.js"></script>
   <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
</head>

<body class ="prediction-page">
<header style="background: black; padding: 20px; text-align: center;">
   <form id="search-form">
      <input type="text" id="searchInput" placeholder="Search..." aria-label="Barre de recherche" style="color: white; background: black;">
   </form>
   <h1 id="title" style="font-family: 'Dancing Script', cursive; font-size: 2.8rem; text-transform: capitalize; letter-spacing: 2px; color: white; background: black;">
      Estimation du rendement agricole <br> 
   </h1>
</header>

</header>
    <div class="pred-form"
    <form>
        <label>Température (°C) :</label>
        <input type="number" id="temperature" name="temperature" step="0.1" required><br>

        <label>Précipitations (mm) :</label>
        <input type="number" id="precipitation" name="precipitation" step="0.1" required><br>

        <label>Émissions de CO2 (MT) :</label>
        <input type="number" id="co2" name="co2" step="0.1" required><br>

        <button type="button" onclick="predictYield()">Estimer</button>
    </form>
    </div>

    <p id="result"></p>

    <script>
        function predictYield() {
            let temperature = document.getElementById("temperature").value;
            let precipitation = document.getElementById("precipitation").value;
            let co2 = document.getElementById("co2").value;

            if (!temperature || !precipitation || !co2) {
                document.getElementById("result").innerHTML = "Veuillez remplir tous les champs.";
                return;
            }

            fetch("http://localhost:5000/predict", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    "temperature": parseFloat(temperature),
                    "precipitation": parseFloat(precipitation),
                    "co2": parseFloat(co2)
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error("Problème avec le serveur Flask.");
                }
                return response.json();
            })
            .then(data => {
                document.getElementById("result").innerHTML = 
                    "Rendement estimé : " + data.prediction.toFixed(2) + " MT/ha";
            })
            .catch(error => {
                document.getElementById("result").innerHTML = "Erreur : " + error.message;
                console.error("Erreur :", error);
            });
        }
    </script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    if (document.body.classList.contains("prediction-page")) {
        const body = document.body;

        // Générer la pluie (uniquement au début)
        for (let i = 0; i < 100; i++) {
            let raindrop = document.createElement("div");
            raindrop.classList.add("raindrop");
            raindrop.style.left = Math.random() * 100 + "vw";
            raindrop.style.animationDuration = (Math.random() * 0.5 + 0.5) + "s";
            body.appendChild(raindrop);
        }

        // Ajouter le soleil
        let sun = document.createElement("div");
        sun.classList.add("sun");
        body.appendChild(sun);

        // Transition de la nuit vers le jour
        setTimeout(() => {
            body.classList.add("daytime");
            document.querySelectorAll(".raindrop").forEach(drop => {
                drop.style.opacity = "0"; // Disparition progressive de la pluie
                setTimeout(() => drop.remove(), 2000);
            });
        }, 5000); // Début du jour après 5 secondes
    }
});
</script>


</body>
</html>
