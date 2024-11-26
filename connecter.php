<?php
session_start();
include('bd.php');
$bdd = getBD();

// Récupérer les données du formulaire
$email = $_POST['mail'];
$password = $_POST['mdp'];

// Vérifier si l'email existe dans la base de données
$requete = $bdd->prepare('SELECT * FROM client WHERE email = ?');
$requete->execute([$email]);
$client = $requete->fetch();

// Vérifier le mot de passe
if (!$client || !password_verify($password, $client['password'])) {
    header('Location: connexion.php?error=1'); // Redirection en cas d'erreur
    exit();
} else {
    // Stocker les informations dans la session
    $_SESSION['client'] = array(
        'id' => $client['id'],
        'first_name' => $client['first_name'],
        'last_name' => $client['last_name'],
        'email' => $client['email']
    );
    header('Location: index2.php');
    exit();
}
?>
