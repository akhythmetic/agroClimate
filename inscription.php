<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Client</title>
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
        <h1 class="login-title">CRÉER UN COMPTE CLIENT</h1>
        <div class="login-form">
            <form action="enregistrement.php" method="post">
                <label for="n">Nom :</label>
                <input type="text" id="n" name="n" value="" placeholder="Entrez votre nom" required>

                <label for="p">Prénom :</label>
                <input type="text" id="p" name="p" value="" placeholder="Entrez votre prénom" required>

                <label for="adr">Adresse :</label>
                <input type="text" id="adr" name="adr" value="" placeholder="Entrez votre adresse" required>

                <label for="num">Numéro de téléphone :</label>
                <input type="text" id="num" name="num" value="" placeholder="Entrez votre numéro de téléphone" required>

                <label for="mail">Adresse e-mail :</label>
                <input type="email" id="mail" name="mail" value="" placeholder="Entrez votre e-mail" required>

                <label for="mdp1">Mot de passe :</label>
                <input type="password" id="mdp1" name="mdp1" placeholder="Choisissez un mot de passe" required>

                <label for="mdp2">Confirmer votre mot de passe :</label>
                <input type="password" id="mdp2" name="mdp2" placeholder="Confirmez votre mot de passe" required>

                <button type="submit" class="login-button">S'inscrire</button>
            </form>
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
