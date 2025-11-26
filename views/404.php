<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>page introuvable</title>
    <link rel="stylesheet" href="styles/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php
        require_once 'objets/header.php'
    ?>

    <main class="container text-center my-5">
        <h1>404 - Page Not Found</h1>
        <p>La page que vous avez demandée n'existe pas.</p>
    </main>

    <?php
        require_once 'objets/footer.php'
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>