<?php
header('Content-Type: application/json');
include("bd.php");

$query = "
    SELECT 
        p.region, 
        AVG(c.precipitations_totales) AS precipitations_totales
    FROM 
        climat c
    JOIN 
        pays p ON c.id_pays = p.id_pays
    WHERE 
        p.region IN ('Ile-de-France', 'Grand Est', 'Nouvelle-Aquitaine', 'Provence-Alpes-Côte d\'Azur')
    AND 
        c.annee IN (1999, 2019)
    GROUP BY 
        p.region
";

$bdd = getBD();
$stmt = $bdd->query($query);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Retourner les données au format JSON
echo json_encode($data);
?>
