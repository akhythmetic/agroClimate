<?php
function getBD() {
    try {
        // Connexion à la base de données avec PDO
        $pdo = new PDO('mysql:host=localhost;dbname=gestion_projet;charset=utf8','root','root');
        return $pdo;
    } catch (PDOException $e) {}
}
?>
