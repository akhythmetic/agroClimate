<?php
// Inclusion du fichier contenant la fonction getBD()
require_once 'bd.php';

// Récupérer les données des pays
try {
    $pdo = getBD(); // Appel à la fonction getBD() définie dans bd.php
    $sql = "SELECT nom, CO2_emissions_MT AS EmissionsCO2 FROM pays";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // Conversion des résultats en JSON
    header("Content-Type: application/json");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} catch (PDOException $e) {
    echo json_encode(["error" => "Erreur lors de l'exécution de la requête : " . $e->getMessage()]);
    exit;
}
?>
