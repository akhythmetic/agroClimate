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
            <p>
                Les précipitations jouent un rôle crucial dans l'agriculture en France, influençant directement la productivité des cultures et la disponibilité en eau pour l'irrigation. Ces dernières années, une baisse notable des taux de précipitations a été observée dans plusieurs régions françaises, exacerbant les défis agricoles.
                
                En Île-de-France, cette diminution a impacté les cultures céréalières, essentielles à la région, nécessitant une gestion accrue des ressources hydriques. Dans le Grand Est, connu pour ses vignobles, la sécheresse et le déficit hydrique compromettent la qualité des raisins et augmentent les coûts de production. La Nouvelle-Aquitaine, importante pour les cultures maraîchères et le maïs, subit une pression accrue sur ses systèmes d'irrigation, menaçant la durabilité des exploitations agricoles. Enfin, en Provence-Alpes-Côte d'Azur, région déjà marquée par un climat sec, la baisse des précipitations aggrave les risques de désertification et les incendies, réduisant la surface agricole utile.
                
                Ces changements climatiques nécessitent des stratégies d'adaptation telles que la diversification des cultures, des techniques d'irrigation efficientes et une gestion raisonnée des sols pour assurer la résilience du secteur agricole.</p>
           
            <canvas id="graphImpactClimat" class="content-graph"></canvas>
        </div>

        <script>
            
            const labels = ['Ile-de-France', 'Grand Est', 'Nouvelle-Aquitaine', 'Provence-Alpes-Côte d\'Azur']; 
            const data = {
                labels: labels,
                datasets: [
                    {
                        label: 'Précipitations 1999 (mm)',
                        data: [1000, 900, 850, 800], 
                        backgroundColor: 'rgba(75, 192, 192, 0.6)', 
                        borderColor: 'rgba(75, 192, 192, 1)', 
                        borderWidth: 1
                    },
                    {
                        label: 'Précipitations 2019 (mm)',
                        data: [850, 750, 720, 700], 
                        backgroundColor: 'rgba(255, 99, 132, 0.6)', 
                        borderColor: 'rgba(255, 99, 132, 1)', 
                        borderWidth: 1
                    }
                ]
            };

           
            const config = {
                type: 'bar', 
                data: data,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Précipitations (mm)'
                            }
                        }
                    }
                }
            };

            
            const ctx = document.getElementById('graphImpactClimat').getContext('2d');
            new Chart(ctx, config);
        </script>

       
        <p class="intro-text-actu">RENDEMENT AGRICOLE ET STRATÉGIES D’ADAPTATION</p>
        <div class="aligned-section right-align">
            <canvas id="graphAdaptation" class="content-graph"></canvas>
            <p>Les engrais chimiques et les pesticides jouent un rôle clé dans l'amélioration du rendement agricole en France. Les engrais enrichissent le sol en nutriments essentiels, tels que l'azote, le phosphore et le potassium, favorisant ainsi une croissance optimale des cultures. De leur côté, les pesticides protègent les cultures contre les maladies, les ravageurs et les mauvaises herbes, réduisant les pertes agricoles. L'utilisation raisonnée de ces intrants contribue à augmenter la productivité des terres agricoles, permettant de répondre aux besoins alimentaires croissants tout en maximisant les récoltes sur des surfaces limitées.</p>
        </div>
        <script>
          
            const dataAdaptation = {
                labels: [0, 20, 40, 60, 80, 100], 
                datasets: [
                    {
                        label: 'Rendement avec engrais chimiques (c/ha)',
                        data: [5, 15, 35, 50, 65, 80], 
                        borderColor: 'rgba(255, 99, 132, 1)', 
                        backgroundColor: 'rgba(255, 99, 132, 0.2)', 
                        borderWidth: 2,
                        fill: false
                    },
                    {
                        label: 'Rendement avec pesticides (c/ha)',
                        data: [10, 25, 40, 55, 65, 70], 
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)', 
                        borderWidth: 2,
                        fill: false
                    }
                ]
            };
        
            
            const configAdaptation = {
                type: 'line', 
                data: dataAdaptation,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Quantité d\'utilisation (kg/ha)'
                            },
                            type: 'linear', 
                            min: 0, 
                            max: 100, 
                            ticks: {
                                stepSize: 10, 
                                callback: function(value) {
                                    return value ; 
                                }
                            },
                            beginAtZero: true
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Rendement agricole (c/ha)' 
                            },
                            beginAtZero: true
                        }
                    }
                }
            };
        
           
            const ctxAdaptation = document.getElementById('graphAdaptation').getContext('2d');
            new Chart(ctxAdaptation, configAdaptation);
        </script>
        
        
        

       
        <p class="intro-text-actu">TEMPERATURES MOYENNES EN ARGENTINE</p>
        <div class="aligned-section right-align">
            <canvas id="graphTempCultures" class="content-graph"></canvas>
            <p>En Argentine, les températures moyennes varient considérablement selon les régions, notamment dans les Pampas, la Patagonie, le Nord-Ouest et le Nord-Est. Cependant, une tendance globale à la hausse des températures a été observée au fil du temps, sous l'effet du changement climatique. Cette augmentation affecte directement l'agriculture, un secteur clé du pays. Dans les Pampas, cœur agricole de l'Argentine, la hausse des températures entraîne des stress hydriques et une réduction de la productivité des cultures. En Patagonie, le réchauffement modifie les cycles des cultures adaptées aux climats froids. Dans les régions du Nord-Ouest et du Nord-Est, où les températures sont déjà élevées, cette tendance exacerbe les défis liés à la gestion des ressources en eau et à la lutte contre les ravageurs. Ces évolutions soulignent l'importance d'adopter des pratiques agricoles résilientes face au climat.</p>
        </div>
        <script>
            
            const labelsTempCultures = ['Pampas', 'Patagonia', 'Northwest', 'Northeast']; 
            const dataTempCultures = {
                labels: labelsTempCultures,
                datasets: [
                    {
                        label: 'Températures 2004 (°C)',
                        data: [18, 12, 20, 25], 
                        backgroundColor: 'rgba(169, 169, 169, 0.6)', 
                        borderColor: 'rgba(169, 169, 169, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Températures 2014 (°C)',
                        data: [20, 15, 22, 28], 
                        backgroundColor: 'rgba(0, 0, 0, 0.6)', 
                        borderColor: 'rgba(0, 0, 0, 1)', 
                        borderWidth: 1
                    }
                ]
            };
        
            
            const configTempCultures = {
                type: 'bar', 
                data: dataTempCultures,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Températures moyennes (°C)' 
                            }
                        }
                    }
                }
            };
        
            
            const ctxTempCultures = document.getElementById('graphTempCultures').getContext('2d');
            new Chart(ctxTempCultures, configTempCultures);
        </script>
        
        


        
        <p class="intro-text-actu">ÉVOLUTION DES ÉMISSIONS DE CO2 EN RUSSIE</p>
        <div class="aligned-section left-align">
            <p>Cette courbe illustre l'évolution des émissions de CO2 en Russie montrant une tendance générale à la hausse au fil des années, en grande partie en raison de son économie fortement dépendante des énergies fossiles, notamment le charbon, le gaz naturel, et le pétrole. Cette augmentation des émissions contribue au réchauffement climatique, qui a des répercussions significatives sur l'agriculture. En Russie, les changements climatiques engendrés par les émissions de CO2 ont entraîné des variations des températures, une modification des cycles de précipitations et une augmentation de la fréquence des événements climatiques extrêmes. Ces facteurs affectent la productivité agricole, modifient les saisons de culture et augmentent les risques de perte des récoltes, posant des défis pour la sécurité alimentaire et la durabilité des systèmes agricoles.</p>
            <canvas id="graphCO2" class="content-graph"></canvas>
        </div>
        <script>
            
            const labelsCO2 = ['1990', '1995', '2000', '2005', '2010'];
            const dataCO2 = {
                labels: labelsCO2,
                datasets: [
                    {
                        label: 'Émissions de CO2 (millions de tonnes)',
                        data: [70, 180, 290, 320, 370], 
                        borderColor: 'rgba(255, 0, 0, 1)',
                        backgroundColor: 'rgba(255, 0, 0, 0.2)', 
                        borderWidth: 2, 
                        fill: false 
                    }
                ]
            };

            
            const configCO2 = {
                type: 'line', 
                data: dataCO2,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: false,
                            title: {
                                display: true,
                                text: 'Années',
                                color: 'black'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Émissions de CO2 (millions de tonnes)',
                                color: 'black'
                            }
                        }
                    }
                }
            };

           
            const ctxCO2 = document.getElementById('graphCO2').getContext('2d');
            new Chart(ctxCO2, configCO2);
        </script>

       
        <p class="final-paragraph">Les données montrent une corrélation entre l’augmentation des températures et la baisse des rendements agricoles dans certaines régions. Les stratégies d'adaptation, comme l'utilisation des produits chimiques, ont prouvé leur efficacité pour atténuer ces impacts. Cependant, les émissions de CO2 restent un défi majeur pour l'agriculture durable.</p>

        <a href="index2.html" class="button">Retour à l'accueil</a>
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
