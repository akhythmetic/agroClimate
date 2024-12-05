<?php
header('Content-Type: application/json');
include("bd.php");

$query = "
    SELECT 
        p.region, 
        AVG(p.CO2_emissions_MT) AS CO2_emissions_moyennes
    FROM 
        pays p
    WHERE 
        p.nom_pays = 'Russie'
    AND 
        p.annee IN (1990 : 2010)
    GROUP BY 
        p.region
";

$bdd = getBD();
$stmt = $bdd->query($query);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Retourner les données au format JSON
echo json_encode($data);
?>
