<!-- CSS Bootstrap -->
<!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="navbar.css">

 JS Bootstrap + Popper 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>-->

<header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-container">
        <!--<img src="images/logo.png" class="logo_dungeon" alt="DungeonXplorer logo" id="logo" onclick="document.location.reload(false)">-->
            <a class="navbar-brand" href="index.php">
                <h3 class="mb-0" href="index.php">DungeonXplorer</h3>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="index.php">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link" href="pages/chapter/chapter_view.php">Chapitres</a></li>
                    <li class="nav-item"><a class="nav-link" href="monsters.php">Monstres</a></li>
                    <?php
                        if(isset($_SESSION["username"])){
                            echo '<li class="nav-item"><a class="nav-link" href="pages/account/account.php">Compte</a></li>';
                        }
                        else{
                            echo '<li class="nav-item"><a class="nav-link" href="pages/account/signIn.php">Connexion</a></li>';
                            echo '<li class="nav-item"><a class="nav-link" href="pages/account/signUp.php">S\'incrire</a></li>';
                        }
                    

                    ?>
                </ul>
            </div>
        </nav>
    </header>