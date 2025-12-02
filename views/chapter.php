<?php
require_once 'controllers/ChapterController.php'; // Assurez-vous que ce chemin est correct
if (!isset($chapter)) {
    // Si la variable $chapter n'est pas définie, redirige vers une page d'erreur ou affiche un message
    echo "Chapitre non défini.";
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

    <h1>Chapitre <?php echo $chapter->getId(); ?></h1>
    <h2><?php echo $chapter->getTitle(); ?></h2>
    <img src="<?php echo $chapter->getImage(); ?>" alt="Image de chapitre" style="max-width: 100%; height: auto;">
    <p><?php echo $chapter->getDescription(); ?></p>

    <h2>Choisissez votre chemin:</h2>
    <ul>
        <?php foreach ($chapter->getChoices() as $choice): ?>
            <li>
                <a href="index.php?chapter=<?php echo $choice['chapter']; ?>">
                    <?php echo $choice['text']; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <?php require_once 'views/objets/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
