<?php
    require_once "connexion.php";

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creation de Personnage</title>
    <link href="../styles/main.css" rel="stylesheet">
    <script src="../scripts/creationperso.js" defer></script>
</head>
<body>
    
    <form action="traitementperso.php" method="post">
        <h1>Créez votre personnage !</h1>
        <label class="classe" for="class-select">Choisissez une classe</label>
        <select class="classe" name="classes" id="class-select" required>
            <option value="void"></option>
            <option value="warrior">Guerrier</option>
            <option value="rogue">Voleur</option>
            <option value="mage">Magicien</option>
        </select>
        <div class="stats">
            <label for="hp">Points de Vie : </label>
            <div id="hp">0</div>
            <label for="init">Initiative : </label>
            <div id="init">0</div>
            <label for="stren">Force : </label>
            <div id="stren">0</div>
            <label for="mana">Mana : </label>
            <div id="mana">0</div>
            <label for="hp">Équipement : </label>
            <div id="stuff">0</div>
        </div>
        <img id="icon" src="../images/rien.jpg">
        <div id="desc">...</div>
        <input type="submit" value="Créer Personnage" class="create">
    </form>
</select>
</body>
</html>