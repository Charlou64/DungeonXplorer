<?php
require_once '../connexion.php';

session_start();
if (!isset($_SESSION["username"])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: accountConnect.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compte Utilisateur - Dungeon Xplorer</title>
    <link rel="stylesheet" href="../../styles.css">
</head>
<body>
    <!-- header -->

    <main>
        <h2>Bienvenue sur votre page de compte</h2>
        <p>Gérez vos informations personnelles, consultez votre historique de jeu et modifiez vos préférences.</p>
        <!-- Contenu spécifique au compte utilisateur -->
    </main>
    
    <!-- footer -->
</body>
