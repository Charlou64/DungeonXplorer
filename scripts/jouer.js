// Ajouter un écouteur d'événement pour le bouton "Démarrer le Jeu"
document.getElementById('startGameBtn').addEventListener('click', startGame);

// Fonction pour démarrer le jeu
function startGame() {
    document.getElementById('startGameBtn').style.display = 'none';//bouton démarrer le jeu disparaît
    document.getElementById('gameArea').style.display = 'block';//zone de jeu apparaît

    fetch('jouer.php')//appel au script PHP
        .then(response => response.json())//conversion de la réponse en JSON
        .then(data => {
            document.getElementById('gameMessage').textContent = data.message;//affichage du message de bienvenue
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Une erreur est survenue.');
        });
}
