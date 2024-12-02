<?php
function enregistrer($nom, $prenom, $adresse, $email, $numero, $mdp, $pays) {
    include('bd.php'); 
    $bdd = getBD(); 

    $requete = $bdd->prepare(
        'INSERT INTO client (first_name, last_name, address, phone, email, country, password) VALUES (?, ?, ?, ?, ?, ?, ?)'
    );
    $requete->execute([
        $prenom, $nom, $adresse, $numero, $email, $pays, password_hash($mdp, PASSWORD_DEFAULT)
    ]);
}

if (
    empty($_POST['n']) || 
    empty($_POST['p']) || 
    empty($_POST['mail']) || 
    empty($_POST['mdp1']) || 
    empty($_POST['adr']) || 
    empty($_POST['num']) || 
    empty($_POST['pays']) || 
    $_POST['mdp1'] !== $_POST['mdp2'] || 
    !filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)
) {
    $url = 'inscription.php?' . http_build_query([
        'n' => $_POST['n'] ?? '',
        'p' => $_POST['p'] ?? '',
        'adr' => $_POST['adr'] ?? '',
        'num' => $_POST['num'] ?? '',
        'mail' => $_POST['mail'] ?? '',
        'pays' => $_POST['pays'] ?? '',
        'error' => 'missing_fields'
    ]);
    header('Location: ' . $url);
    exit();
} else {
    enregistrer(
        $_POST['n'], 
        $_POST['p'], 
        $_POST['adr'], 
        $_POST['mail'], 
        $_POST['num'], 
        $_POST['mdp1'],
        $_POST['pays']
    );
    header('Location: index2.php');
    exit();
}
?>
