<!-- CSS Bootstrap -->
<!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="navbar.css">

 JS Bootstrap + Popper 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>-->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DungeonXplorer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $_SESSION["basepath"]; ?>/styles/main.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-container ">
        <!--<img src="images/logo.png" class="logo_dungeon" alt="DungeonXplorer logo" id="logo" onclick="document.location.reload(false)">-->
            <a class="navbar-brand" href="<?php echo $_SESSION["basepath"]; ?>">
                <h3 class="mb-0">DungeonXplorer</h3>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="<?php echo $_SESSION["basepath"]; ?>">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $_SESSION["basepath"]; ?>/chapter/1">Chapitres</a></li>
                    <?php
                        if(isset($_SESSION["username"])){
                            echo '<li class="nav-item"><a class="nav-link" href="'.$_SESSION["basepath"].'/character">Personnages</a></li>';
                            echo '<li class="nav-item"><a class="nav-link" href="'.$_SESSION["basepath"].'/account">Compte</a></li>';
                        }
                        else{
                            echo '<li class="nav-item"><a class="nav-link" href="'.$_SESSION["basepath"].'/account/signIn">Connexion</a></li>';
                            echo '<li class="nav-item"><a class="nav-link" href="'.$_SESSION["basepath"].'/account/signUp">S\'incrire</a></li>';
                        }
                    ?>
                </ul>
            </div>
        </nav>
    </header>