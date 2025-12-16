<main class="img_base">
    <div class="hero-text">
        <h1>Bienvenue dans Dungeon Xplorer</h1>
        <h2>Choisissez votre aventure</h2>
        <p class="text-light">Plongez dans un monde rempli de mystères, de monstres et de trésors. Sélectionnez un chapitre pour commencer votre quête!</p>
        <?php if (isset($_SESSION["username"])): ?>
            <a href="<?php echo $_SESSION["basepath"]; ?>/character" class="btn text-light">Démarrer l'aventure</a>
        <?php else: ?>
            <a href="<?php echo $_SESSION["basepath"]; ?>/account/signIn" class="btn text-light">Se connecter</a>
        <?php endif; ?>
    </div>
</main>
