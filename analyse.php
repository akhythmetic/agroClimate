<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analyse des Données Agricoles</title>
    <link rel="stylesheet" href="style2.css">
    <link rel="icon" href="photos/logosite.png" type="image/png">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <header>
        <form id="search-form">
            <input type="text" id="searchInput" placeholder="Search..." aria-label="Barre de recherche">
        </form>
        <h1>ANALYSE DES DONNÉES AGRICOLES, CLIMATIQUES ET ÉCONOMIQUES</h1>
    </header>

    <section class="main-content">
        <p class="intro-text-actu">IMPACT DU CLIMAT SUR L’AGRICULTURE</p>
        <div class="aligned-section left-align">
            <p>Ce graphique montre l'évolution des précipitations annuelles sur plusieurs décennies. On observe une forte variabilité d'une année à l'autre, sans tendance claire à l'augmentation ou à la diminution. Certains pics de précipitations indiquent des années exceptionnellement humides, tandis que des creux marquent des périodes de sécheresse relative. Cette instabilité climatique peut avoir un impact direct sur l'agriculture et la disponibilité des ressources en eau.</p>
            <canvas id="graphImpactClimat" class="content-graph"></canvas>
        </div>
        </section>

        <!-- 1E GRAPHE -->
        <script>
    const data = <?php
        require_once 'bd.php'; 

        $pdo = getBD();
        $region = 'Grand Est';
        $sql = "
           SELECT annee AS annee, SUM(precipitations_totales) AS total_precipitation
            FROM climat, pays
            where region= :region
            GROUP BY annee
            ORDER BY annee ASC;
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':region', $region, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        
        echo json_encode($data);
    ?>;

    console.log(data); 
    
    const labels = data.map(item => item.annee);
    const precipitations = data.map(item => item.total_precipitation);

    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById("graphImpactClimat").getContext("2d");
        new Chart(ctx, {
            type: "line",
            data: {
                labels: labels,
                datasets: [{
                    label: "Précipitations par année (mm)",
                    data: precipitations,
                    backgroundColor: "rgba(75, 192, 192, 0.6)",
                    borderColor: "rgba(75, 192, 192, 1)",
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: { title: { display: true, text: "Années" } },
                    y: {
            title: {
                display: true,
                text: "Précipitations (mm)"
            },
            beginAtZero: false, 
            min: Math.min(...precipitations) * 0.9, 
            max: Math.max(...precipitations) * 1.1 
        }
                }
            }
        });
    });
</script>


<section class="main-content">
        <!-- Titre et deuxième paragraphe à droite avec image à gauche -->
        <p class="intro-text-actu">RENDEMENT AGRICOLE ET STRATÉGIES D’ADAPTATION</p>
        <div class="aligned-section right-align">
            <canvas id="graphImpactRendement" class="content-graph"></canvas>
            <p>Ce nuage de points met en relation l'impact économique et le rendement agricole en tonnes par hectare (MT/HA). On remarque une certaine corrélation positive : à mesure que l'impact économique augmente, le rendement agricole tend à être plus élevé. Cela pourrait indiquer que des investissements accrus dans les stratégies d'adaptation ou dans les infrastructures agricoles permettent d'améliorer la productivité des cultures.</p>
            </div>
            
           


<!-- DEUXIÈME GRAPHE !!!!-->

<script>
    const dataImpactRendement = <?php  
        try {
            $pdo = getBD();
            $sql = "SELECT pays.nom, AVG(agriculture.impact_economique) AS moyenne_impact, AVG(agriculture.rendement_agricole_MT_per_HA) AS moyenne_rendement 
            FROM pays, environnement, agriculture 
            WHERE pays.id_pays = agriculture.id_pays 
            and agriculture.id_environnement = environnement.id_environnement 
            GROUP BY pays.nom ORDER BY moyenne_impact ASC;";

            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $pays = [];
            $moyenneImpact = [];
            $moyenneRendement = [];

            foreach ($data as $row) {
                $pays[] = $row['nom'];
                $moyenneImpact[] = $row['moyenne_impact'];
                $moyenneRendement[] = $row['moyenne_rendement'];
            }

            echo json_encode([
                'pays' => $pays,
                'moyenneImpact' => $moyenneImpact,
                'moyenneRendement' => $moyenneRendement
            ]);
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
        
    ?>;

    if (dataImpactRendement.error) {
        console.error("Erreur SQL:", dataImpactRendement.error);
    } else {
        const pays = dataImpactRendement.pays; 
        const moyenneImpact = dataImpactRendement.moyenneImpact;
        const moyenneRendement = dataImpactRendement.moyenneRendement;

const configImpactRendement = {
    type: "scatter",
    data: {
        datasets: [
            {
                label: "Impact économique vs Rendement",
                data: moyenneRendement.map((rendement, index) => ({ x: moyenneImpact[index], y: rendement })),
                borderColor: "rgba(255, 99, 132, 1)",
                backgroundColor: "rgba(255, 99, 132, 0.2)",
                borderWidth: 2,
                fill: false,
                pointRadius: 5
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: "top"
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return `${context.dataset.data[context.dataIndex].label}: ${context.formattedValue}`;
                    }
                }
            },
            annotation: {
                annotations: moyenneRendement.map((rendement, index) => ({
                    type: "label",
                    xValue: moyenneImpact[index],
                    yValue: rendement,
                    content: pays[index],
                    fontSize: 12,
                    fontColor: "black"
                }))
            }
        },
        scales: {
            x: {
                title: {
                    display: true,
                    text: "Impact économique"
                },
                type: "linear",
                min: Math.min(...moyenneImpact) * 0.9, 
                max: Math.max(...moyenneImpact) * 1.1, 
                beginAtZero: false
            },
            y: {
                title: {
                    display: true,
                    text: "Rendement agricole (MT/HA)"
                },
                min: Math.min(...moyenneRendement) * 0.9, 
                max: Math.max(...moyenneRendement) * 1.1, 
                beginAtZero: false
            }
        }
    }
};
        const ctxImpactRendement = document.getElementById("graphImpactRendement").getContext("2d");
        new Chart(ctxImpactRendement, configImpactRendement);
    }
</script>

        
        

        <!-- Titre et troisième paragraphe à droite avec image à gauche -->
        <p class="intro-text-actu">TEMPÉRATURES MOYENNES PAR CULTURE ET ANNÉE</p>
        <div class="aligned-section left-align">
            <p>Ce graphique illustre la relation entre la température moyenne et l’indice de santé des sols. Il semble que l’indice de santé des sols reste relativement stable malgré les variations de température, bien que l'on observe une certaine dispersion des points. Cela suggère que d'autres facteurs, tels que les pratiques agricoles, l'humidité du sol et la gestion des ressources, jouent un rôle crucial dans la préservation de la qualité des sols.</p>
            <canvas id="graphTempCultures" class="content-graph"></canvas>
        </div>
        

       <!-- CANVAS -->
<canvas id="graphTemperatureSanteSols" class="content-graph"></canvas>

<!-- CHART.JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- SCRIPT PHP POUR RÉCUPÉRER LES DONNÉES -->
<script>
    const dataTemperatureSanteSols = <?php
    try {
        $pdo = getBD();
        $sql = "SELECT pays.nom, AVG(temperature_moyenne) as temperature_moyenne, AVG(indice_sante_sols) as indice_sante_sols
                FROM climat, environnement, agriculture, pays
                WHERE agriculture.id_environnement = environnement.id_environnement
                AND agriculture.id_agriculture = climat.id_agriculture
                AND agriculture.id_pays = pays.id_pays
                GROUP BY pays.nom
                ORDER BY COUNT(pays.nom) DESC
                LIMIT 15;";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($data);
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
    ?>;

    if (dataTemperatureSanteSols.error) {
        console.error("Erreur SQL:", dataTemperatureSanteSols.error);
    } else {
        const labelsPays = dataTemperatureSanteSols.map(pays => pays.nom);
        const labelsTemperature = dataTemperatureSanteSols.map(pays => pays.temperature_moyenne);
        const labelsSanteSols = dataTemperatureSanteSols.map(pays => pays.indice_sante_sols);

        const configTemperatureSanteSols = {
            type: "bar",
            data: {
                labels: labelsPays,
                datasets: [
                    {
                        label: "Indice de santé des sols en fonction de la température",
                        data: labelsSanteSols,
                        borderColor: "rgba(255, 99, 132, 1)",
                        backgroundColor: "rgba(255, 99, 132, 0.2)",
                        borderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: "top" }
                },
                scales: {
                    x: {
                        title: { display: true, text: "Pays" },
                        type: "category"
                    },
                    y: {
                        title: { display: true, text: "Indice de santé des sols" },
                        min: Math.min(...labelsSanteSols) * 0.9
                    }
                }
            }
        };

        const ctxTemperatureSanteSols = document.getElementById("graphTemperatureSanteSols").getContext("2d");
        new Chart(ctxTemperatureSanteSols, configTemperatureSanteSols);
    }
</script>

        
        


        <!-- Titre et quatrième paragraphe à gauche avec image à droite -->
        <p class="intro-text-actu">ÉVOLUTION DES ÉMISSIONS DE CO2</p>
        <div class="aligned-section left-align">
            <p>Cette courbe illustre l’évolution des émissions de dioxyde de carbone (CO2) directement attribuables aux activités agricoles dans différents pays 
                 étudiées. Ces émissions incluent des sources telles que l’utilisation de machines agricoles, les procédés de fertilisation chimique, l’élevage intensif, et la gestion des sols. En montrant les variations des niveaux de CO2 au fil des années, elle met en lumière non seulement l’impact des pratiques agricoles actuelles sur l’environnement, mais également les progrès réalisés dans certaines zones pour réduire cette empreinte écologique.</p>
            <canvas id="graphCO2" class="content-graph"></canvas>
        </div>
       
        <!-- QUATRIÈME GRAPHE -->
<canvas id="graphEmissionsCO2Moyenne" class="content-graph"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const dataEmissionsCO2Moyenne = <?php  
        try {
            $pdo = getBD();
            $sql = "SELECT pays.nom, AVG(pays.CO2_emissions_MT) AS moyenne_emissions 
                    FROM pays 
                    GROUP BY pays.nom 
                    ORDER BY moyenne_emissions DESC;";

            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $pays = [];
            $moyenneEmissions = [];

            foreach ($data as $row) {
                $pays[] = $row['nom'];
                $moyenneEmissions[] = $row['moyenne_emissions'];
            }

            echo json_encode([
                'pays' => $pays,
                'moyenneEmissions' => $moyenneEmissions
            ]);
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
        
    ?>;

    if (dataEmissionsCO2Moyenne.error) {
        console.error("Erreur SQL:", dataEmissionsCO2Moyenne.error);
    } else {
        const labelsPays = dataEmissionsCO2Moyenne.pays; 
        const moyenneEmissions = dataEmissionsCO2Moyenne.moyenneEmissions; 

        const configEmissionsCO2Moyenne = {
            type: "bar",
            data: {
                labels: labelsPays, 
                datasets: [
                    {
                        label: "Moyenne des émissions de CO2",
                        data: moyenneEmissions,
                        borderColor: "rgb(24, 119, 7)",
                        backgroundColor: "rgb(24, 119, 7)",
                        borderWidth: 2,
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: "top"
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: "Pays"
                        },
                        type: "category",
                        beginAtZero: true
                    },
                    y: {
                        title: {
                            display: true,
                            text: "Moyenne des émissions de CO2 (MT)"
                        },
                        min: Math.min(...moyenneEmissions) * 0.9, 
                        max: Math.max(...moyenneEmissions) * 1.1, 
                        beginAtZero: false
                    }
                }
            }
        };

        const ctxEmissionsCO2Moyenne = document.getElementById("graphEmissionsCO2Moyenne").getContext("2d");
        new Chart(ctxEmissionsCO2Moyenne, configEmissionsCO2Moyenne);
    }
</script>

        <p class="final-paragraph">Les données montrent une corrélation entre l’augmentation des températures et la baisse des rendements agricoles dans certaines régions. Les stratégies d'adaptation, comme la rotation des cultures, ont prouvé leur efficacité pour atténuer ces impacts. Cependant, les émissions de CO2 restent un défi majeur pour l'agriculture durable.</p>

        <a href="index2.php" class="button">Retour à l'accueil</a>
    </section>

    <footer>
        <p>© 2024 - Tous droits réservés</p>
    </footer>

    <script>
        // Script JavaScript pour gérer la recherche
        document.getElementById('search-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Empêche le rechargement de la page

            // Récupère la valeur de l'entrée utilisateur
            const query = document.getElementById('searchInput').value.trim().toLowerCase();

            // page d'actualité
            if (query === "actualité" || query === "actualités" || query === "actualites" || query === "actualite") {
                window.location.href = "actualites.html"; 
            }

            //page d'equipe
            if (query === "équipe" || query === "equipe" || query === "team" || query === "our team") {
                window.location.href = "ourteam.html"; 
            } 
            //page d'accueil
            if (query === "accueil") {
                window.location.href = "index2.php"; 
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
</body>

</html>
