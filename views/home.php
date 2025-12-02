<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dungeon Xplorer</title>
    <link rel="stylesheet" href="<?php echo $_SESSION["basepath"]; ?>/styles/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Navbar -->
    <?php
        require_once 'objets/header.php'
    ?>

    <!-- Main Content (Hero Section) -->
    <main class="img_base d-flex">
        <!-- Colonne pour l'image (première moitié) -->
        <div class="col-6 image-column">
            <div class="hero-text">
                <h1>Bienvenue dans Dungeon Xplorer</h1>
                <h2>Choisissez votre aventure</h2>
                <p class="text-light">Plongez dans un monde rempli de mystères, de monstres et de trésors. Sélectionnez un chapitre pour commencer votre quête!</p>
                <a href="<?php echo $_SESSION["basepath"]; ?>/chapter/1" class="btn text-light">Voir les chapitres</a>
            </div>
        </div>

        <!-- Colonne pour le carrousel (deuxième moitié) -->
        <div class="col-6 carousel-column">
            <div id="imageCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row">
                            <div class="col-6">
                                <img src="path/to/image1.jpg" class="d-block w-100" alt="Image 1">
                            </div>
                            <div class="col-6">
                                <img src="path/to/image2.jpg" class="d-block w-100" alt="Image 2">
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row">
                            <div class="col-6">
                                <img src="path/to/image3.jpg" class="d-block w-100" alt="Image 3">
                            </div>
                            <div class="col-6">
                                <img src="images/scene-fantastique-en-3d.jpg" class="d-block w-100" alt="Image 4">
                            </div>
                        </div>
                    </div>
                    <!-- Ajoutez d'autres éléments carousel-item ici -->
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Précédent</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#imageCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Suivant</span>
                </button>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <?php
        require_once 'views/objets/footer.php'
    ?>

    <!-- JS Bootstrap + Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
