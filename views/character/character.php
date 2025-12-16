<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Mes Personnages</h1>
        <a href="<?php echo $_SESSION['basepath']; ?>/character/create" class="btn btn-success">Créer un personnage</a>
    </div>
    <div class="row">
        <?php
        // Récupération des personnages de l'utilisateur
        if ($characters) {
            foreach ($characters as $character) {
                ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($character->getName(), ENT_QUOTES, 'UTF-8'); ?></h5>
                            <p class="card-text">Classe: <?php echo htmlspecialchars($character->getClass() ? $character->getClass()->getName() : 'Aucune', ENT_QUOTES, 'UTF-8'); ?></p>
                            <p class="card-text">Niveau: <?php echo (int) $character->getCurrentLevel(); ?></p>
                            <a href="<?php echo $_SESSION["basepath"]; ?>/character/<?php echo (int) $character->getId(); ?>" class="btn btn-primary">Voir Détails</a>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p>Vous n'avez pas encore de personnages. Créez-en un pour commencer votre aventure!</p>";
        }
        ?>
    </div>
</div>
