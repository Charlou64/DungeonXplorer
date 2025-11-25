<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JDR</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/jouer.css">
</head>
<body>
    <h1>Bienvenue dans DungeonXplorer</h1>
    <p>Cliquez sur "<i class="fas fa-play"></i> " pour démarrer la partie.</p>
    <button id="startGameBtn"><i class="fas fa-play"></i> </button>
    
    <div id="gameArea" style="display:none;">
        <h2>Votre aventure commence !</h2>
        <p id="gameMessage"></p>
        <button id="nextStepBtn">crée votre personnage !</button>
    </div>

    <script src="scripts/jouer.js"></script>
</body>
</html>
