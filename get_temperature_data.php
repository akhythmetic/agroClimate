<?php
header('Content-Type: application/json');
include("bd.php");

$query = "
    SELECT 
        p.region, 
        AVG(c.temperature_moyenne) AS temperature_moyenne
    FROM 
        climat c
    JOIN 
        pays p ON c.id_pays = p.id_pays
    WHERE 
        p.region IN ('Pampas', 'Patagonia', 'Northwest', 'Northeast')
    AND 
        c.annee = 2004
        c.annee = 2014
    GROUP BY 
        p.region
";

$bdd = getBD();
$stmt = $bdd->query($query);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Retourner les données au format JSON
echo json_encode($data);
?>
