<?php
session_start();
require_once 'bd.php'; // Connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $question = $_POST['question'] ?? '';

    try {
        $pdo = getBD();

        // Vérifier l'utilisateur
        $stmt = $pdo->prepare("SELECT id_client FROM clients WHERE mail = :email AND mdp = :password");
        $stmt->execute(['email' => $email, 'password' => $password]);

        $client = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($client) {
            // Insérer la question
            $stmt = $pdo->prepare("INSERT INTO questions (id_client, question) VALUES (:id_client, :question)");
            $stmt->execute(['id_client' => $client['id_client'], 'question' => $question]);

            echo "<p>Votre question a été envoyée avec succès !</p>";
        } else {
            echo "<p>Email ou mot de passe incorrect.</p>";
        }
    } catch (Exception $e) {
        echo "<p>Erreur : " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poser une question</title>
    <link rel="stylesheet" href="style2.css">
    <link rel="icon" href="photos/logosite.png" type="image/png">
</head>
<body class="connexion-page">
    <header class="connexion-header">
    <form id="search-form">
        <input type="text" id="searchInput" placeholder="Search..." aria-label="Barre de recherche">
     </form>
        <h1>Poser une question</h1>
    </header>
    <main>
        <form class="connexion-form" method="POST" action="">
            <label for="email" class="connexion-label">Adresse e-mail :</label>
            <input type="email" id="email" name="email" class="connexion-input" required>
            
            <label for="password" class="connexion-label">Mot de passe :</label>
            <input type="password" id="password" name="password" class="connexion-input" required>
            
            <label for="question" class="connexion-label">Votre question :</label>
            <textarea id="question" name="question" class="connexion-textarea" rows="5" required></textarea>
            
            <button type="submit" class="connexion-button">Envoyer</button>
            
        </form>
        
    </main>
    <a href="FAQ.html" class="retour-bouton">Retour</a>

    <footer class="connexion-footer">
        <p>© 2024 - Tous droits réservés</p>
    </footer>

    <script>
    // Script JavaScript pour gérer la recherche
    document.getElementById('search-form').addEventListener('submit', function(event) {
        event.preventDefault(); // Empêche le rechargement de la page

        // Récupère la valeur de l'entrée utilisateur++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        const query = document.getElementById('searchInput').value.trim().toLowerCase();

        // page d'actualité
        if (query === "actualité" || query === "actualités" || query === "actualites"|| query === "actualite") {
            window.location.href = "actualites.html"; 
        } 

        //page d'equipe
        if (query === "équipe" || query === "equipe" || query === "team" || query === "our team") {
            window.location.href = "ourteam.html"; 
        } 
        //page d'analyses
        if (query === "analyse" || query === "analyses") {
            window.location.href = "analyse.html"; 
        } 

        //page d'illustrations
        if (query === "illustrations" || query === "illustration" || query === "visualisations" || query === "visualisation") {
            window.location.href = "illustrations.html";
        } 

        //page de connexion
        if (query === "connexion" || query === "client" || query === "inscription") {
            window.location.href = "connexion.php"; 
        } 

        //page d'interviews
        if (query === "interview" || query === "interviews") {
            window.location.href = "interviews.html"; 
        } 
        
        //page d'accueil
        if (query === "accueil") {
            window.location.href = "index2.html"; 
        } 

        else {
            alert("Aucune page correspondante trouvée !"); 
        }

        
    });

</script>

</body>
</html>