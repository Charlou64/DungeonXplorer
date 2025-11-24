<?php

require_once 'pages/connexion.php';

?>


<doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dungeon Xplorer</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Bienvenue dans Dungeon Xplorer</h1>

        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="chapters.php">Chapitres</a></li>
                <li><a href="monsters.php">Monstres</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Choisissez votre aventure</h2>
        <p>Plongez dans un monde rempli de mystères, de monstres et de trésors. Sélectionnez un chapitre pour commencer votre quête!</p>
        <a href="chapters.php" class="btn">Voir les chapitres</a>
    </main>
    <footer>
        <p>&copy; 2024 Dungeon Xplorer. Tous droits réservés.</p>
    </footer>
</body>