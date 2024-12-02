<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('bd.php');
    $bdd = getBD();

    $email = $_POST['email'];

    // Vérifier si l'e-mail existe
    $requete = $bdd->prepare('SELECT id FROM client WHERE email = ?');
    $requete->execute([$email]);
    $client = $requete->fetch();

    if ($client) {
        // Générer un jeton unique
        $token = bin2hex(random_bytes(50));
        $expiration = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Enregistrer le jeton dans la base de données
        $requete = $bdd->prepare('INSERT INTO password_resets (email, token, expiration) VALUES (?, ?, ?)');
        $requete->execute([$email, $token, $expiration]);

        // Envoyer un e-mail avec le lien de réinitialisation
        $resetLink = "http://yourwebsite.com/new_password.php?token=$token";
        mail(
            $email,
            "Réinitialisation de votre mot de passe",
            "Cliquez sur ce lien pour réinitialiser votre mot de passe : $resetLink",
            "From: no-reply@yourwebsite.com"
        );

        $message = "Un e-mail de réinitialisation a été envoyé.";
    } else {
        $error = "Adresse e-mail introuvable.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <main class="login-container">
        <h1 class="login-title">Réinitialiser votre mot de passe</h1>
        <div class="login-form">
            <form method="POST" action="reset_password.php">
                <label for="email">Adresse e-mail :</label>
                <input type="email" id="email" name="email" placeholder="Entrez votre e-mail" required>
                <button type="submit" class="login-button">Envoyer</button>
            </form>

            <?php if (isset($message)): ?>
                <p style="color: green;"><?= $message ?></p>
            <?php elseif (isset($error)): ?>
                <p style="color: red;"><?= $error ?></p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
