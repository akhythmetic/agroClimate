<?php
function getBD() {
    try {
        // Modifier les informations de connexion selon vos paramètres
        $host = 'localhost';
        $dbname = 'gestion_projet';
        $username = 'root';
        $password = 'root';

        // Connexion à la base de données avec PDO
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die('Erreur : ' . $e->getMessage());
    }
}
?>
