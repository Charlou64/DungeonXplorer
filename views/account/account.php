<main class="img_base">
    <div class="container my-5 justify-content-center">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Informations du compte</h2>
                        <div class="mb-3">
                            <p class=" font-text"><strong>Nom d'utilisateur :</strong> <?php echo htmlspecialchars($user["username"]); ?></p>
                        </div>
                        <div class="mb-3">
                            <p class=" font-text"><strong>Email :</strong> <?php echo htmlspecialchars($user["email"]); ?></p>
                        </div>
                        <div class="mb-3">
                            <p class=" font-text"><strong>Membre depuis :</strong> <?php echo htmlspecialchars($user["created_at"]); ?></p>
                        </div>
                        <form action="<?php echo $_SESSION["basepath"]; ?>/logout" method="post">
                            <button type="submit" class="couleur-bouton w-100">Se déconnecter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
