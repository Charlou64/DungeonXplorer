<?php

//require_once 'pages/connexion.php';

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dungeon Xplorer</title>
    <link rel="stylesheet" href="styles/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark">

    <!-- Navbar -->
    <?php
        require_once 'pages/objets/header.php'
    ?>

    <!-- Main Content (Hero Section) -->
    <main class="img_base">
        <div class="hero-text">
            <h1>Bienvenue dans Dungeon Xplorer</h1>
            <h2>Choisissez votre aventure</h2>
            <p class="text-light">Plongez dans un monde rempli de mystères, de monstres et de trésors. Sélectionnez un chapitre pour commencer votre quête!</p>
            <a href="pages/chapter/chapter_view.php" class="btn text-light">Voir les chapitres</a>
        </div>
    </main>
    <div class="container my-5 justify-content-center">
        <div class="row justify-content-center">
            <div class="col-md-8 hero-text">
                <h1>Bienvenue sur DungeonXplorer, l'univers de dark fantasy où se mêlent aventure, stratégie et immersion totale dans les récits interactifs.</h1>
                <p>Ce projet est né de la volonté de l’association Les Aventuriers du Val Perdu de raviver l’expérience unique des livres dont vous êtes le héros. Notre vision : offrir à la communauté un espace où chacun peut incarner un personnage et plonger dans des quêtes épiques et personnalisées.</p>
                <p>Dans sa première version, DungeonXplorer permettra aux joueurs de créer un personnage parmi trois classes emblématiques — guerrier, voleur, magicien — et d’évoluer dans un scénario captivant, tout en assurant à chacun la possibilité de conserver sa progression.</p>
                <h3>Nous sommes enthousiastes de partager avec vous cette application et espérons qu'elle saura vous
                plonger au cœur des mystères du Val Perdu !</h3>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <?php
        require_once 'pages/objets/footer.php'
    ?>
    <!-- JS Bootstrap + Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
