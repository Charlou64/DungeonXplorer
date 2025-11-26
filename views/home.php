<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dungeon Xplorer</title>
    <link rel="stylesheet" href="styles/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Navbar -->
    <?php
        require_once 'objets/header.php'
    ?>

    <!-- Main Content (Hero Section) -->
    <main>
        <section class="hero-section">
            <div class="hero-text">
                <h1>Bienvenue dans Dungeon Xplorer</h1>
                <h2>Choisissez votre aventure</h2>
                <p>Plongez dans un monde rempli de mystères, de monstres et de trésors. Sélectionnez un chapitre pour commencer votre quête!</p>
                <a href="chapter/1" class="btn">Voir les chapitres</a>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <?php
        require_once 'objets/footer.php'
    ?>
    <!-- JS Bootstrap + Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
