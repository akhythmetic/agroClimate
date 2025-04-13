<?php
error_reporting(E_ALL);
error_log("Accès à bd.php");
ini_set('display_errors', 1);
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Fonction pour récupérer la connexion à la base de données
function getBD() {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=gestion_projet;charset=utf8', 'root', 'root', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,  // Active les erreurs SQL
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // Récupération en tableau associatif
        ]);
        return $pdo;
    } catch (PDOException $e) {
        die(json_encode(["error" => "Erreur de connexion : " . $e->getMessage()]));
    }
}

// Vérifie que la requête est bien en GET
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Connexion à la base de données
    $pdo = getBD();
    
    // Exécute la requête SQL pour récupérer toutes les données nécessaires
    try {
        $sql = "SELECT Annee, Pays, Region, Type_culture, Temperature_moyenne, Precipitations_totales, 
                        Emissions_CO2, Rendement_agricole, Nb_d_evenements_climatiques_extremes, 
                        pourcentage_irrigation, Pesticides_kg_per_HA, Engrais_kg_per_HA, Indice_de_sante_des_sols, 
                        Strategies_adaptation, Impact_economique 
                FROM table_global";

        $stmt = $pdo->query($sql);
        $data = $stmt->fetchAll();

        // Vérifie si les données sont vides
        if (empty($data)) {
            echo json_encode(["error" => "Aucune donnée trouvée"]);
        } else {
            echo json_encode($data);
        }
    } catch (PDOException $e) {
        echo json_encode(["error" => "Erreur SQL : " . $e->getMessage()]);
    }
} else {
    echo json_encode(["error" => "Méthode non autorisée"]);
}
?>
