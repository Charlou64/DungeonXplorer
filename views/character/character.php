<div class="container mt-4">
    <h1>Mes Personnages</h1>
    <div class="row">
        <?php
        // Récupération des personnages de l'utilisateur
        $stmt = $bdd->prepare("SELECT * FROM Characters WHERE owner = :owner");
        $stmt->execute([':owner' => $_SESSION["username"]]);
        $characters = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($characters) {
            foreach ($characters as $character) {
                ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($character['name']); ?></h5>
                            <p class="card-text">Classe: <?php echo htmlspecialchars($character['class']); ?></p>
                            <p class="card-text">Niveau: <?php echo htmlspecialchars($character['level']); ?></p>
                            <a href="<?php echo $_SESSION["basepath"]; ?>/character/view/<?php echo $character['id']; ?>" class="btn btn-primary">Voir Détails</a>
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
