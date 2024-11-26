<?php
session_start(); // Démarrage de la session

// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('bd.php'); // Inclure la connexion à la base de données
    $bdd = getBD(); // Connexion à la base de données

    // Récupération des données du formulaire
    $email = $_POST['mail'];
    $password = $_POST['mdp'];

    // Vérifier si l'email existe dans la base de données
    $requete = $bdd->prepare('SELECT * FROM client WHERE email = ?');
    $requete->execute([$email]);
    $client = $requete->fetch(); // Récupère l'utilisateur si trouvé

    if ($client && password_verify($password, $client['password'])) {
        // Si le mot de passe est valide
        $_SESSION['client_id'] = $client['id']; // Stocke l'ID de l'utilisateur dans la session
        $_SESSION['client_email'] = $client['email']; // Stocke l'email de l'utilisateur dans la session

        // Rediriger l'utilisateur vers la page d'accueil après la connexion
        header('Location: index2.php');
        exit();
    } else {
        // Si l'email ou le mot de passe est incorrect
        $error_message = "Adresse e-mail ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <header>
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Search...">
            <button id="searchButton">🔍</button>
        </div>
    </header>

    <main class="login-container">
        <h1 class="login-title">DÉJÀ CLIENT ?</h1>
        <div class="login-form">
            <div class="login-avatar">
                <img src="photos/tete_connexion.jpg" alt="Avatar" class="avatar-image">
            </div>
            <form action="connexion.php" method="post">
                <label for="mail">Adresse e-mail :</label>
                <input type="email" id="mail" name="mail" placeholder="Entrez votre e-mail" required>
                
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="mdp" placeholder="Entrez votre mot de passe" required>
                
                <div class="options">
                    <label>
                        <input type="checkbox" name="remember"> Se souvenir de moi
                    </label>
                    <a href="#" class="forgot-password">Mot de passe oublié</a>
                </div>
                <button type="submit" class="login-button">Se connecter</button>
            </form>

            <?php if (isset($error_message)): ?>
                <p style="color: red;"><?= $error_message ?></p>
            <?php endif; ?>

            <div class="auth-buttons">
                <p>Pas de compte ? <a href="inscription.php">Créer un nouveau compte</a></p>
            </div>
        </div>
    </main>
    <footer>
        <p>© 2024 - Tous droits réservés</p>
    </footer>

    <script>
        // Fonction de recherche
        const searchInput = document.getElementById('searchInput');
        const searchButton = document.getElementById('searchButton');

        searchButton.addEventListener('click', function() {
            const query = searchInput.value.trim().toLowerCase();
            const routes = {
                "actualité": "actualites.html",
                "actualités": "actualites.html",
                "actualites": "actualites.html",
                "actualite": "actualites.html",
                "équipe": "ourteam.html",
                "equipe": "ourteam.html",
                "team": "ourteam.html",
                "our team": "ourteam.html",
                "analyse": "analyse.html",
                "analyses": "analyse.html",
                "illustration": "illustrations.html",
                "illustrations": "illustrations.html",
                "visualisation": "illustrations.html",
                "visualisations": "illustrations.html",
                "accueil": "index2.php",
                "interview": "interviews.html",
                "interviews": "interviews.html"
            };
            if (routes[query]) {
                window.location.href = routes[query];
            } else {
                alert("Aucune page correspondante trouvée !");
            }
        });

        searchInput.addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                searchButton.click();
            }
        });
    </script>
</body>
</html>
