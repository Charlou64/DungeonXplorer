<?php
require_once '../connexion.php';

session_start();

if (isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["password"])) {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO Users (username, password_hash, email) VALUES ('".$username."',
                '".$hashed_password."',
                '".$email."')";

    $stmt = $bdd->prepare($sql);

    if ($stmt->execute()) {
        $_SESSION["username"] = $username;
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
        <form action="signUp.php" method="post">
            <h2>Créer un nouveau compte</h2>
            <label for="username">Nom d'utilisateur :</label>
            <input type="text" id="username" name="username" required>

            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>
            
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">S'inscrire</button>
        </form>
    </main>

    <!-- footer -->
</body>
</html>
