document.getElementById('startGameBtn').addEventListener('click', startGame);

function startGame() {
    document.getElementById('startGameBtn').style.display = 'none';
    document.getElementById('gameArea').style.display = 'block';

    fetch('start_game.php')
        .then(response => response.json())
        .then(data => {
            document.getElementById('gameMessage').textContent = data.message;
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Une erreur est survenue.');
        });
}

document.getElementById('nextStepBtn').addEventListener('click', nextStep);

function nextStep() {
    fetch('next_step.php')
        .then(response => response.json())
        .then(data => {
            document.getElementById('gameMessage').textContent = data.message;
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Une erreur est survenue.');
        });
}
