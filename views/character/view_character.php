<?php
if (!isset($character) || !$character) {
    echo "<div class=\"container mt-4\"><p>Personnage introuvable.</p></div>";
    return;
}
?>
<div class="container mt-4">
    <a href="<?php echo $_SESSION['basepath']; ?>/character" class="btn btn-secondary mb-3">← Retour aux personnages</a>

    <div class="card mb-4 character-card">
        <div class="card-body">
            <div class="character-header">
                <div class="character-meta">
                    <h2 class="card-title"><?php echo htmlspecialchars($character->getName(), ENT_QUOTES, 'UTF-8'); ?></h2>
                    <div class="muted">Niveau <?php echo (int)$character->getCurrentLevel(); ?> — XP: <?php echo (int)$character->getXp(); ?></div>
                    <p class="mb-2"><?php echo nl2br(htmlspecialchars($character->getBiography(), ENT_QUOTES, 'UTF-8')); ?></p>

                    <h5 class="mb-2">Caractéristiques</h5>
                    <ul class="stats-list">
                        <li>PV: <?php echo (int)$character->getPv(); ?></li>
                        <li>Mana: <?php echo (int)$character->getMana(); ?></li>
                        <li>Force: <?php echo (int)$character->getStrength(); ?></li>
                        <li>Initiative: <?php echo (int)$character->getInitiative(); ?></li>
                        <li>Classe: <?php echo htmlspecialchars($character->getClass() ? $character->getClass()->getName() : 'Aucune', ENT_QUOTES, 'UTF-8'); ?></li>
                    </ul>

                    <h5 class="mb-2">Équipement</h5>
                    <ul class="equip-list">
                        <li>Armure: <?php $armor = $character->getArmorItem(); echo htmlspecialchars($armor ? $armor->getName() : 'Aucun', ENT_QUOTES, 'UTF-8'); ?></li>
                        <li>Arme principale: <?php $pw = $character->getPrimaryWeaponItem(); echo htmlspecialchars($pw ? $pw->getName() : 'Aucune', ENT_QUOTES, 'UTF-8'); ?></li>
                        <li>Arme secondaire: <?php $sw = $character->getSecondaryWeaponItem(); echo htmlspecialchars($sw ? $sw->getName() : 'Aucune', ENT_QUOTES, 'UTF-8'); ?></li>
                        <li>Bouclier: <?php $sh = $character->getShieldItem(); echo htmlspecialchars($sh ? $sh->getName() : 'Aucun', ENT_QUOTES, 'UTF-8'); ?></li>
                    </ul>
                </div>

                <?php if ($character->getImage()): ?>
                <div class="avatar-frame ms-auto">
                    <img src="<?php echo htmlspecialchars($character->getImage(), ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($character->getName(), ENT_QUOTES, 'UTF-8'); ?>">
                </div>
                <?php endif; ?>
            </div>

            <div class="character-actions">
                <div>
                    <a href="<?php echo $_SESSION['basepath']; ?>/chapter/1" class="btn btn-secondary">Commencer une nouvelle aventure</a>

                    <?php if ($character->getChapterId() && $character->getChapterId() > 1): ?>
                        <a href="<?php echo $_SESSION['basepath']; ?>/chapter/<?php echo (int)$character->getChapterId(); ?>" class="btn btn-secondary">Reprendre l'aventure</a>
                    <?php endif; ?>
                </div>

                <div class="ms-auto">
                    <form method="post" action="<?php echo $_SESSION['basepath']; ?>/character/<?php echo (int)$character->getId(); ?>" onsubmit="return confirm('Confirmer la suppression du personnage ?');" style="margin:0;">
                        <input type="hidden" name="_action" value="delete">
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>