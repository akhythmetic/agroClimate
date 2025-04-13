<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['ready'])) {
    // Page de chargement avant exécution du script Python
    $year = htmlspecialchars($_POST['annee']);
    $type_culture = htmlspecialchars($_POST['type_culture']);

    echo "<!DOCTYPE html>
    <html lang='fr'>
    <head>
        <meta charset='UTF-8'>
        <title>Chargement...</title>
        <style>
            body {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                height: 100vh;
                background-color: #f6f4ef;
                font-family: 'Segoe UI', sans-serif;
                color: #444;
            }
            .loader {
                border: 10px solid #eee;
                border-top: 10px solid #5e8b7e;
                border-radius: 50%;
                width: 80px;
                height: 80px;
                animation: spin 1s linear infinite;
            }
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            .text {
                margin-top: 20px;
                text-align: center;
                font-size: 1.2rem;
            }
        </style>
    </head>
    <body>
        <div class='loader'></div>
        <div class='text'>Analyse en cours...<br>Veuillez patienter.</div>
        <form id='redirectForm' method='POST' action=''>
            <input type='hidden' name='annee' value='$year'>
            <input type='hidden' name='type_culture' value='$type_culture'>
            <input type='hidden' name='ready' value='1'>
        </form>
        <script>
            setTimeout(() => {
                document.getElementById('redirectForm').submit();
            }, 1000);
        </script>
    </body>
    </html>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ready'])) {
    $year = intval($_POST['annee']);
    $type_culture = escapeshellarg(trim($_POST['type_culture']));

    $script = "C:\\MAMP\\htdocs\\Gestiondeprojets\\predict_eco.py";
    $python = "C:\\Users\\rmaze\\AppData\\Local\\Programs\\Python\\Python310\\python.exe";
    $command = "\"$python\" \"$script\" $year $type_culture";

    $output = shell_exec("$command 2>&1");

    echo "<!DOCTYPE html>
    <html lang='fr'>
    <head>
        <meta charset='UTF-8'>
        <title>Résultat de la prédiction</title>
        <script src='https://cdn.plot.ly/plotly-2.27.0.min.js'></script>
        <style>
            body {
                background-color: #fdfbf7;
                font-family: 'Segoe UI', sans-serif;
                padding: 2rem;
                margin: 0;
            }
            h3 {
                text-align: center;
                color: #333;
            }
            #graph-container {
                max-width: 1000px;
                margin: 2rem auto;
                padding: 1rem;
                background-color: #fff;
                border-radius: 10px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                width: 100%;
                overflow-x: auto;
            }
            .back-button {
                position: fixed;
                bottom: 20px;
                left: 20px;
                background-color: #5e8b7e;
                color: white;
                border: none;
                padding: 0.6rem 1rem;
                border-radius: 8px;
                text-decoration: none;
                font-weight: bold;
                transition: background-color 0.3s ease;
            }
            .back-button:hover {
                background-color: #48685e;
            }
        </style>
    </head>
    <body>
        <h3>Résultats de la prédiction pour l'année $year et le type de culture " . htmlspecialchars($_POST['type_culture']) . "</h3>
        <div id='graph-container'>$output</div>
        <script>
            window.addEventListener('resize', function() {
                Plotly.Plots.resize(document.getElementById('graph-container'));
            });
        </script>
        <a class='back-button' href='prediction_eco.php'>&larr; Retour</a>
    </body>
    </html>";
} else {
    echo "<p style='font-family: sans-serif;'>Veuillez revenir à la <a href='prediction_eco.php'>page de prédiction</a> pour effectuer une prédiction.</p>";
}
?>
