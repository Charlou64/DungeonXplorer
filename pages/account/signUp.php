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
    <link rel="stylesheet" href="../../styles/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- header -->
    <?php require_once '../objets/header.php'; ?>
    <!--
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
    -->
    <main class="img_base">
        <div class="container my-5 justify-content-center">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title text-center mb-4">Créer un nouveau compte</h2>
                            <form action="signUp.php" method="post">
                                <div class="mb-3">
                                    <label for="username" class=" font-text">Nom d'utilisateur :</label>
                                    <input type="text" id="username" name="username"  class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class=" font-text">Email :</label>
                                    <input type="email" id="email" name="email" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class=" font-text">Mot de passe :</label>
                                    <input type="password" id="password" name="password" class="form-control" required>
                                </div>
                                <button type="submit" class="couleur-bouton w-100">S'inscrire</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- footer -->
    <?php require_once '../objets/footer.php'; ?>

</body>
</html>
