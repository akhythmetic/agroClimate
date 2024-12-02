<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('bd.php');
    $bdd = getBD();

    $token = $_POST['token'];
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $error = "Les mots de passe ne correspondent pas.";
    } else {
        // Vérifier le jeton
        $requete = $bdd->prepare('SELECT email FROM password_resets WHERE token = ? AND expiration > NOW()');
        $requete->execute([$token]);
        $reset = $requete->fetch();

        if ($reset) {
            // Mettre à jour le mot de passe
            $email = $reset['email'];
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            $requete = $bdd->prepare('UPDATE client SET password = ? WHERE email = ?');
            $requete->execute([$hashed_password, $email]);

            // Supprimer le jeton
            $requete = $bdd->prepare('DELETE FROM password_resets WHERE email = ?');
            $requete->execute([$email]);

            $message = "Votre mot de passe a été réinitialisé avec succès.";
        } else {
            $error = "Lien de réinitialisation invalide ou expiré.";
        }
    }
} elseif (isset($_GET['token'])) {
    $token = $_GET['token'];
} else {
    header('Location: connexion.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau mot de passe</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <main class="login-container">
        <h1 class="login-title">Nouveau mot de passe</h1>
        <div class="login-form">
            <form method="POST" action="new_password.php">
                <input type="hidden" name="token" value="<?= htmlspecialchars($token ?? '') ?>">
                
                <label for="password">Nouveau mot de passe :</label>
                <input type="password" id="password" name="password" placeholder="Entrez un nouveau mot de passe" required>

                <label for="confirm_password">Confirmer le mot de passe :</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirmez le mot de passe" required>

                <button type="submit" class="login-button">Réinitialiser</button>
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
