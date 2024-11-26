<?php
// Fonction pour enregistrer un utilisateur dans la base de données
function enregistrer($nom, $prenom, $adresse, $email, $numero, $mdp, $pays) {
    // Inclure la connexion à la base de données
    include('bd.php'); 
    $bdd = getBD(); 

    // Préparer la requête pour insérer les données dans la base de données
    $requete = $bdd->prepare('INSERT INTO client (last_name, first_name, address, email, phone, password, country) 
                              VALUES (?, ?, ?, ?, ?, ?, ?)');
    $requete->execute([
        $nom, 
        $prenom, 
        $adresse, 
        $email, 
        $numero, 
        password_hash($mdp, PASSWORD_DEFAULT), // Hashage du mot de passe
        $pays // Ajout du pays dans la requête
    ]);
}

// Vérification des données reçues par le formulaire
if (
    empty($_POST['n']) || // Vérifie que le champ nom n'est pas vide
    empty($_POST['p']) || // Vérifie que le champ prénom n'est pas vide
    empty($_POST['mail']) || // Vérifie que le champ email n'est pas vide
    empty($_POST['mdp1']) || // Vérifie que le champ mot de passe n'est pas vide
    empty($_POST['adr']) || // Vérifie que le champ adresse n'est pas vide
    empty($_POST['num']) || // Vérifie que le champ numéro n'est pas vide
    empty($_POST['pays']) || // Vérifie que le champ pays n'est pas vide
    $_POST['mdp1'] !== $_POST['mdp2'] || // Vérifie que les mots de passe correspondent
    !filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL) // Vérifie si l'email est valide
) {
    // Construire l'URL avec les données déjà saisies pour les pré-remplir
    // Note : Les mots de passe ne devraient pas être envoyés dans l'URL pour des raisons de sécurité
    $url = 'inscription.php?n=' . urlencode($_POST['n']) .
           '&p=' . urlencode($_POST['p']) .
           '&adr=' . urlencode($_POST['adr']) .
           '&num=' . urlencode($_POST['num']) .
           '&mail=' . urlencode($_POST['mail']) .
           '&pays=' . urlencode($_POST['pays']);
    
    // Rediriger vers la page d'inscription avec les données pré-remplies (sans mots de passe)
    header('Location: ' . $url);
    exit();
} else {
    // Enregistrer les données dans la base de données
    enregistrer(
        $_POST['n'], 
        $_POST['p'], 
        $_POST['adr'], 
        $_POST['mail'], 
        $_POST['num'], 
        $_POST['mdp1'],
        $_POST['pays'] // Ajouter le pays ici
    );

    // Rediriger vers la page d'accueil après un enregistrement réussi
    header('Location: index2.php');
    exit();
}
?>
