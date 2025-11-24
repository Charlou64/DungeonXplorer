<?php
require_once '../connexion.php'; 

session_start();

if (isset($_POST["username"], $_POST["password"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Récupération de l'utilisateur par username
    $sql = "SELECT * FROM Users WHERE username = :username LIMIT 1";
    $stmt = $bdd->prepare($sql);

    $stmt->execute([
        ':username' => $username
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Vérification du mot de passe
        if (password_verify($password, $user['password_hash'])) {
            $_SESSION["username"] = $user["username"];
            echo "Connexion réussie !";
            // Redirection possible
            // header("Location: dashboard.php");
            exit;
        } else {
            echo "Mot de passe incorrect.";
        }
    } else {
        echo "Utilisateur introuvable.";
    }
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
        <form action="signIn.php" method="post">
            <h2>Connexion à votre compte</h2>
            <label for="username">Nom d'utilisateur :</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Se connecter</button>
        </form>
    </main>
    
    <!-- footer -->
</body>
