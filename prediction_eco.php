<?php
// Récupérer les données de l’API comme dans a.py
$url = "http://localhost/Gestiondeprojets/bd.php";
$response = file_get_contents($url);
$data = json_decode($response, true);

// Initialisation
$annees = [];
$types_culture = [];

if (is_array($data)) {
    foreach ($data as $row) {
        if (isset($row['Annee'])) {
            $annees[] = intval($row['Annee']);
        }
        if (isset($row['Type_culture'])) {
            $types_culture[] = $row['Type_culture'];
        }
    }
    // Uniques et triés
    $annees = array_unique($annees);
    sort($annees);
    $types_culture = array_unique($types_culture);
    sort($types_culture);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Prédiction de l'impact économique</title>
    <link rel="stylesheet" href="style2.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f5f0;
            margin: 0;
            padding: 0;
        }

        .container {
            text-align: center;
            padding: 50px;
        }

        h2 {
            font-size: 2em;
            color: #3e3e3e;
            margin-bottom: 40px;
        }

        form {
            display: inline-block;
            background-color: #ffffff;
            padding: 30px 40px;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
            font-weight: bold;
            color: #444;
            text-align: left;
        }

        select, input[type="submit"] {
            padding: 10px;
            margin-top: 5px;
            font-size: 1em;
            border-radius: 8px;
            border: 1px solid #ccc;
            width: 200px;
        }

        input[type="submit"] {
            background-color: #5e8b7e;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 20px;
        }

        input[type="submit"]:hover {
            background-color: #4d766a;
        }

        .back-button {
            position: fixed;
            bottom: 20px;
            left: 20px;
            background-color: #ccc;
            padding: 10px 20px;
            border-radius: 10px;
            color: #333;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .back-button:hover {
            background-color: #aaa;
        }
    </style>
</head>
<body>
    <h2>Formulaire de prédiction</h2>
    <form action="predict_result.php" method="POST">
        <label for="annee">Année :</label>
        <select name="annee" id="annee" required>
            <?php foreach ($annees as $year): ?>
                <option value="<?= $year ?>"><?= $year ?></option>
            <?php endforeach; ?>
        </select>

        <label for="type_culture">Type de culture :</label>
        <select name="type_culture" id="type_culture" required>
            <?php foreach ($types_culture as $culture): ?>
                <option value="<?= htmlspecialchars($culture) ?>"><?= htmlspecialchars($culture) ?></option>
            <?php endforeach; ?>
        </select>

        <input type="submit" value="Prédire">
    </form>
    <a class="back-button" href="predictions.php">← Retour</a>
</body>
</html>
