<main class="container my-5 text-white">
    <h1 class="mb-4 text-center">Portail d'Administration</h1>
    
    <div class="row g-4 justify-content-center">
        <div class="col-md-4">
            <div class="card bg-dark border-primary h-100 text-center">
                <div class="card-body d-flex flex-column">
                    <h3 class="card-title text-primary">📜 Chapitres</h3>
                    <p class="card-text flex-grow-1">Créez, modifiez et liez les étapes de votre aventure.</p>
                    <a href="<?= $_SESSION["basepath"] ?>/admin/chapters" class="btn btn-primary mt-3">Gérer les chapitres</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-dark border-danger h-100 text-center">
                <div class="card-body d-flex flex-column">
                    <h3 class="card-title text-danger">⚔️ Bestiaire</h3>
                    <p class="card-text flex-grow-1">Gérez les monstres, leurs statistiques et leur butin.</p>
                    <a href="<?= $_SESSION["basepath"] ?>/admin/monsters" class="btn btn-danger mt-3">Gérer les monstres</a>
                </div>
            </div>
        </div>
    </div>
</main>