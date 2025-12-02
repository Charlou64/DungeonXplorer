<?php
// views/chapter.php

require_once 'controllers/ChapterController.php';
if (!isset($chapter)) {
    include 'views/404.php';
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo $chapter->getTitle(); ?></title>
    <link rel="stylesheet" href="<?php echo $_SESSION["basepath"]; ?>/styles/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php require_once 'views/objets/header.php'; ?>

    <h1><?php echo $chapter->getTitle(); ?></h1>
    <img src="<?php echo $chapter->getImage(); ?>" alt="Image de chapitre" style="max-width: 100%; height: auto;">
    <p><?php echo $chapter->getDescription(); ?></p>

    <?php 
        $choices = $chapter->getChoices(); // Récupération des choix

        if (count($choices) > 0) {
            echo '
            <h2>Choisissez votre chemin:</h2>
            <ul class="list-group">'; 
            
            foreach ($choices as $choice) {
                // Syntaxe PHP correcte et bonnes clés : 'next_chapter_id' et 'description'
                echo '<li class="list-group-item">
                        <a href="' . $_SESSION["basepath"] . '/chapter/' . $choice['next_chapter_id'] . '" class="btn btn-primary">
                            ' . htmlspecialchars($choice['description']) . '
                        </a>
                    </li>';
            }
            echo '</ul>';
        } 
    ?>

    <?php require_once 'views/objets/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>