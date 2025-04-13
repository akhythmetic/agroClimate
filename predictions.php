<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analyse des Données Agricoles</title>
    <link rel="stylesheet" href="style2.css">
    <link rel="icon" href="photos/logosite.png" type="image/png">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .prediction-section {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            margin-bottom: 20px;
        }

        .prediction-section img {
            max-width: 30%;
            height: auto;
            margin-right: 20px;
        }

        .prediction-section p {
            flex: 1;
        }
    </style>
</head>

<body>
    <header>
        <form id="search-form">
            <input type="text" id="searchInput" placeholder="Search..." aria-label="Barre de recherche">
        </form>
        <h1>PREDICTIONS & MACHINE LEARNING</h1>
    </header>

    <section class="prediction-section">
        <img src="photos/xgb.png" alt="Culture agricole et prévisions">
        <p>Le modèle XGBoost utilisé dans cette étude s'avère particulièrement puissant pour prédire le rendement agricole en fonction de variables clés telles que l'impact économique, la température moyenne et les émissions de CO₂. Avec un R² de 0.63, il explique une grande partie de la variabilité du rendement, ce qui montre que ces facteurs ont un lien significatif avec la productivité agricole. L’erreur absolue moyenne (MAE) de 0.50 tonnes par hectare confirme la précision du modèle, malgré la complexité et les incertitudes inhérentes au domaine agricole. Ces performances témoignent de la robustesse du modèle, qui parvient à capturer des relations non linéaires entre les variables, et offre ainsi un outil fiable pour anticiper les rendements agricoles. XGBoost, grâce à sa capacité à gérer des interactions complexes entre les variables, constitue une ressource précieuse pour la planification agricole et la gestion des risques liés au climat. Les résultats obtenus ouvrent la voie à des applications pratiques telles que l’optimisation des ressources agricoles et la préparation aux impacts du changement climatique.</p>
    </section>

    <section class="prediction-section">
        <p><strong>L'impact du rendement agricole sur l'économie</strong><br><br>
        Le système de prédiction mis en place repose sur un modèle d’apprentissage supervisé capable d’estimer l’impact économique lié à une culture agricole pour une année donnée. L’utilisateur sélectionne un type de culture et une année via une interface dynamique ; ces informations sont ensuite injectées dans un algorithme d’intelligence artificielle entraîné à partir de données historiques. Le modèle exploite plusieurs variables agro-climatiques (comme les températures moyennes, les émissions de CO₂, et d’autres indicateurs environnementaux) afin de prédire une valeur chiffrée de rendement économique, exprimée en euros par hectare. Le résultat est présenté sous forme d’un graphique interactif de type <em>scatter plot</em> (nuage de points), enrichi d’annotations et d’une ligne de tendance. Ce type de visualisation permet de situer la prédiction dans un contexte plus large et de visualiser la corrélation entre variables, offrant à l’utilisateur une meilleure compréhension de l’évolution des performances agricoles dans un environnement en mutation.
        <br><br>
        <a href="prediction_eco.php" class="button">Accéder à l'outil de prédiction</a>
        </p>
    </section>


    <p class="final-paragraph">
        Les prédictions issues des données montrent que le rendement agricole est influencé par plusieurs facteurs interdépendants, notamment l'impact économique, la température moyenne et les émissions de dioxyde de carbone. Une hausse des températures, combinée à une intensification des émissions de CO2, contribue à une baisse significative des rendements dans certaines régions. Bien que des stratégies d'adaptation comme la rotation des cultures aient démontré leur efficacité, ces variables complexes posent encore un défi majeur pour l’agriculture durable.
    </p>


    <a href="index2.php" class="button">Retour à l'accueil</a>

    <footer>
        <p>© 2024 - Tous droits réservés</p>
    </footer>

    <script>
        // Script JavaScript pour gérer la recherche
        document.getElementById('search-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Empêche le rechargement de la page

            const query = document.getElementById('searchInput').value.trim().toLowerCase();

            if (query === "actualité" || query === "actualités" || query === "actualites" || query === "actualite") {
                window.location.href = "actualites.php";
            }

            if (query === "équipe" || query === "equipe" || query === "team" || query === "our team") {
                window.location.href = "ourteam.html";
            }

            if (query === "accueil") {
                window.location.href = "index2.php";
            }

            if (query === "illustrations" || query === "illustration" || query === "visualisations" || query === "visualisation") {
                window.location.href = "illustrations.php";
            }

            if (query === "connexion" || query === "client" || query === "inscription") {
                window.location.href = "connexion.php";
            }

            if (query === "interview" || query === "interviews") {
                window.location.href = "interviews.html";
            } else {
                alert("Aucune page correspondante trouvée !");
            }
        });
    </script>
</body>
</html>
