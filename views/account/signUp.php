<main class="img_base">
    <div class="container my-5 justify-content-center">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Créer un nouveau compte</h2>
                        <form action="<?php echo $_SESSION["basepath"]; ?>/account/signUp" method="post">
                            <div class="mb-3">
                                <label for="username" class=" font-text">Nom d'utilisateur :</label>
                                <input type="text" id="username" name="username"  class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class=" font-text">Email :</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class=" font-text">Mot de passe :</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="couleur-bouton w-100">S'inscrire</button>

                            <a href="<?php echo $_SESSION['basepath']; ?>/account/signIn">Vous avez déjà un compte ? Se connecter</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
