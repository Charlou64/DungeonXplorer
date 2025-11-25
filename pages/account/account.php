<?php
require_once '../connexion.php';

session_start();
if (!isset($_SESSION["username"])) {
    header("Location: signIn.php");
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
        <h2>Bienvenue, <?php echo htmlspecialchars($_SESSION["username"]); ?> !</h2>

        <section>
            <h3>Informations du compte</h3>

            <?php
                // Récupération des infos utilisateur
                $stmt = $bdd->prepare("SELECT username, email, created_at FROM Users WHERE username = :username");
                $stmt->execute([':username' => $_SESSION["username"]]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>

            <p><strong>Nom d'utilisateur :</strong> <?php echo htmlspecialchars($user["username"]); ?></p>
            <p><strong>Email :</strong> <?php echo htmlspecialchars($user["email"]); ?></p>
            <p><strong>Membre depuis :</strong> <?php echo htmlspecialchars($user["created_at"]); ?></p>
        </section>

        <section>
            <h3>Déconnexion</h3>
            <form action="logout.php" method="post">
                <button type="submit">Se déconnecter</button>
            </form>
        </section>
    </main>

    
    <!-- footer -->
</body>
