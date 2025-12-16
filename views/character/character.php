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
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <h5 class="card-title mb-1"><?php echo htmlspecialchars($character->getName(), ENT_QUOTES, 'UTF-8'); ?></h5>
                                    <p class="mb-1">
                                        Classe: <?php echo htmlspecialchars($character->getClass() ? $character->getClass()->getName() : 'Aucune', ENT_QUOTES, 'UTF-8'); ?>
                                    </p>
                                    <p class="mb-0">Niveau: <strong><?php echo (int) $character->getCurrentLevel(); ?></strong></p>
                                </div>

                                <?php if ($character->getImage()): ?>
                                    <div class="ms-3" style="min-width:96px;max-width:120px;align-self:flex-start;">
                                        <div style="width:100px;height:100px;overflow:hidden;border-radius:8px;border:1px solid #e9ecef;">
                                            <img src="<?php echo htmlspecialchars($character->getImage(), ENT_QUOTES, 'UTF-8'); ?>"
                                                 alt="<?php echo htmlspecialchars($character->getName(), ENT_QUOTES, 'UTF-8'); ?>"
                                                 style="width:100%;height:100%;object-fit:cover;display:block;">
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="mt-3 mt-auto d-flex justify-content-between align-items-center" style="margin-top:2px;">
                                
                            <a href="<?php echo $_SESSION["basepath"]; ?>/character/<?php echo (int) $character->getId(); ?>"
                                class="btn btn-outline-primary btn-sm">Voir Détails</a>
                            </div>
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
