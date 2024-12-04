<?php
require_once 'bd.php'; // Inclure le fichier contenant la fonction getBD()

try {
    // Connexion à la base de données
    $pdo = getBD();

    // Requête pour récupérer les données (remplacez les noms de colonnes par ceux de votre table)
    $sql = "SELECT indice_sante_sols FROM environnement LIMIT 5";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // Récupérer les résultats sous forme de tableau associatif
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retourner les données en JSON
    header('Content-Type: application/json');
    echo json_encode($data);
} catch (PDOException $e) {
    // Gestion des erreurs
    echo json_encode(['error' => 'Erreur de connexion à la base de données : ' . $e->getMessage()]);
}
?>


