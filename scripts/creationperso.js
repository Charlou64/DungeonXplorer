const select = document.getElementById('class-select');
const image = document.getElementById('icon');
const desc = document.getElementById('desc');
const stats = document.getElementById('stats').getElementsByClassName('stat');
const relancer = document.getElementById('reroll');

function aleaEntre(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

// Fonction qui génère les stats et la description en fonction de la classe
function updateStats(classe) {
    let hp, mana, force, description, imgSrc;

    switch (classe) {
        case "warrior":
            imgSrc = "../images/Berserker.jpg";
            description = "Un guerrier redoutable très robuste et fort physiquement. Il ne peut pas utiliser la magie mais est la classe idéale pour infliger de gros dégats au corps à corps.";
            hp = aleaEntre(35, 60);
            mana = 0;
            force = aleaEntre(30, 55);
            break;
        case "rogue":
            imgSrc = "../images/Thief.jpg";
            description = "Le voleur est très agile et furtif. Au combat, il prend la main au cas où il y a égalité au lancer d'initiative.";
            hp = aleaEntre(20, 40);
            mana = aleaEntre(0, 10);
            force = aleaEntre(20, 35);
            break;
        case "mage":
            imgSrc = "../images/Wizard.jpg";
            description = "Le mage est la classe pour ceux qui aiment bien utiliser des sorts. Il peut faire des dégats importants avec sa magie.";
            hp = aleaEntre(20, 40);
            mana = aleaEntre(30, 50);
            force = aleaEntre(15, 25);
            break;
        default:
            return; // Si aucune classe n'est sélectionnée
    }

    // Mise à jour de l'image
    image.src = imgSrc;

    // Mise à jour de la description
    desc.textContent = description;

    // Mise à jour des statistiques
    for (const stat of stats) {
        if (stat.id === "hp") {
            stat.textContent = hp;
        } else if (stat.id === "mana") {
            stat.textContent = mana;
        } else if (stat.id === "stren") {
            stat.textContent = force;
        } else {
            stat.textContent = aleaEntre(10, 35);
        }
    }
}

// Écouteur d'événements pour la sélection de classe
select.addEventListener('change', () => {
    updateStats(select.value);
});

// Fonction pour "Relancer" les stats
relancer.addEventListener('click', (event) => {
    event.preventDefault();
    updateStats(select.value);  // Relance les stats pour la classe actuellement sélectionnée
});
