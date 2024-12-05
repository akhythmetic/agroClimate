<?php
header('Content-Type: application/json');
include("bd.php");

$query = "
    SELECT 
        e.annee, 
        AVG(e.engrais) AS moyenne_engrais, 
        AVG(e.pesticides) AS moyenne_pesticides
    FROM 
        environnement e
    JOIN 
        pays p ON e.id_pays = p.id_pays
    WHERE 
        p.nom = 'France'
    AND 
        e.annee IN (2004, 2014)
    GROUP BY 
        e.annee
";

$bdd = getBD();
$stmt = $bdd->query($query);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Retourner les données au format JSON
echo json_encode($data);
?>
