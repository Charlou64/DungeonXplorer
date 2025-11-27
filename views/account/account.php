<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compte Utilisateur - Dungeon Xplorer</title>
    <link rel="stylesheet" href="../styles/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- header -->
    <?php require_once 'views/objets/header.php'; ?>
    <main class="img_base">
        <!--
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
-->
        <div class="container my-5 justify-content-center">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title text-center mb-4">Informations du compte</h2>
                            <div class="mb-3">
                                <p class=" font-text"><strong>Nom d'utilisateur :</strong> <?php echo htmlspecialchars($user["username"]); ?></p>
                            </div>
                            <div class="mb-3">
                                <p class=" font-text"><strong>Email :</strong> <?php echo htmlspecialchars($user["email"]); ?></p>
                            </div>
                            <div class="mb-3">
                                <p class=" font-text"><strong>Membre depuis :</strong> <?php echo htmlspecialchars($user["created_at"]); ?></p>
                            </div>
                            <form action="models/logout.php" method="post">
                                <button type="submit" class="couleur-bouton w-100">Se déconnecter</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    
    <!-- footer -->
    <?php require_once 'views/objets/footer.php'; ?>
</body>
