<?php
// ...existing code...
if (!isset($character) || !$character) {
    echo "<div class=\"container mt-4\"><p>Personnage introuvable.</p></div>";
    return;
}
?>
<div class="container mt-4">
    <a href="<?php echo $_SESSION['basepath']; ?>/character" class="btn btn-secondary mb-3">← Retour aux personnages</a>

    <div class="card mb-4">
        <div class="row g-0">
            <?php if ($character->getImage()): ?>
            <div class="col-md-4">
                <img src="<?php echo htmlspecialchars($character->getImage(), ENT_QUOTES, 'UTF-8'); ?>" class="img-fluid rounded-start" alt="<?php echo htmlspecialchars($character->getName(), ENT_QUOTES, 'UTF-8'); ?>">
            </div>
            <?php endif; ?>

            <div class="col">
                <div class="card-body">
                    <h2 class="card-title"><?php echo htmlspecialchars($character->getName(), ENT_QUOTES, 'UTF-8'); ?></h2>
                    <p class="text-muted">Niveau <?php echo (int)$character->getCurrentLevel(); ?> — XP: <?php echo (int)$character->getXp(); ?></p>
                    <p><?php echo nl2br(htmlspecialchars($character->getBiography(), ENT_QUOTES, 'UTF-8')); ?></p>

                    <h5>Caractéristiques</h5>
                    <ul>
                        <li>PV: <?php echo (int)$character->getPv(); ?></li>
                        <li>Mana: <?php echo (int)$character->getMana(); ?></li>
                        <li>Force: <?php echo (int)$character->getStrength(); ?></li>
                        <li>Initiative: <?php echo (int)$character->getInitiative(); ?></li>
                        <li>Classe: <?php echo htmlspecialchars($character->getClass() ? $character->getClass()->getName() : 'Aucune', ENT_QUOTES, 'UTF-8'); ?></li>
                    </ul>

                    <h5>Équipement</h5>
                    <ul>
                        <li>Armure: <?php
                            $armor = $character->getArmorItem();
                            echo htmlspecialchars($armor ? $armor->getName() : 'Aucun', ENT_QUOTES, 'UTF-8');
                        ?></li>

                        <li>Arme principale: <?php
                            $pw = $character->getPrimaryWeaponItem();
                            echo htmlspecialchars($pw ? $pw->getName() : 'Aucune', ENT_QUOTES, 'UTF-8');
                        ?></li>

                        <li>Arme secondaire: <?php
                            $sw = $character->getSecondaryWeaponItem();
                            echo htmlspecialchars($sw ? $sw->getName() : 'Aucune', ENT_QUOTES, 'UTF-8');
                        ?></li>

                        <li>Bouclier: <?php
                            $sh = $character->getShieldItem();
                            echo htmlspecialchars($sh ? $sh->getName() : 'Aucun', ENT_QUOTES, 'UTF-8');
                        ?></li>
                    </ul>

                    <h5>Sorts</h5>
                    <?php $spells = $character->getSpellList(); ?>
                    <?php if (!empty($spells)): ?>
                        <ul>
                            <?php foreach ($spells as $s): ?>
                                <li><?php echo htmlspecialchars(is_array($s) ? json_encode($s, JSON_UNESCAPED_UNICODE) : $s, ENT_QUOTES, 'UTF-8'); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-muted">Aucun sort.</p>
                    <?php endif; ?>

                    <div class="mt-3 d-flex gap-2">
                        <a href="<?php echo $_SESSION['basepath']; ?>/chapter/1" class="btn btn-secondary">Commencer une nouvelle aventure</a>
                        
                        <?php if ($_SESSION['character']->getChapterId() > 1): ?>
                            <a href="<?php echo $_SESSION['basepath']; ?>/chapter/<?php echo (int)$_SESSION['character']->getChapterId(); ?>" class="btn btn-secondary">Reprendre l'aventure</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>