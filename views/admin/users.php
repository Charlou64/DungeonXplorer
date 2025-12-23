<main class="container my-5 text-white">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>👥 Gestion des Utilisateurs</h2>
        <a href="<?= $_SESSION["basepath"] ?>/admin" class="btn btn-outline-light btn-sm">Retour au menu</a>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card bg-dark text-white border-success mb-4">
                <div class="card-body">
                    <h5>➕ Nouvel Utilisateur</h5>
                    <form action="<?= $_SESSION["basepath"] ?>/admin/users/create" method="post">
                        <div class="mb-2">
                            <label class="small">Nom d'utilisateur</label>
                            <input type="text" name="username" class="form-control" placeholder="Pseudo" required>
                        </div>
                        <div class="mb-2">
                            <label class="small">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="email@exemple.com" required>
                        </div>
                        <div class="mb-2">
                            <label class="small">Mot de passe</label>
                            <input type="password" name="password" class="form-control" placeholder="*******" required>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="is_admin" id="isAdminCheck">
                            <label class="form-check-label small" for="isAdminCheck">
                                Définir comme Administrateur
                            </label>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Créer l'utilisateur</button>
                    </form>
                </div>
            </div>

            <div class="card bg-dark text-white border-info">
                <div class="card-body text-center">
                    <h6>Total Utilisateurs</h6>
                    <h2 class="display-6"><?= count($users) ?></h2>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card bg-dark text-white border-light">
                <div class="card-body p-0">
                    <table class="table table-dark table-hover mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Utilisateur</th>
                                <th>Email</th>
                                <th class="text-center">Admin</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                            <tr class="align-middle">
                                <td><?= $user['id'] ?></td>
                                <td>
                                    <strong><?= htmlspecialchars($user['username']) ?></strong>
                                </td>
                                <td><small><?= htmlspecialchars($user['email']) ?></small></td>
                                <td class="text-center">
                                    <?= $user['is_admin'] ? '<span class="badge bg-primary">Admin</span>' : '<span class="badge bg-secondary">Joueur</span>' ?>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group">
                                        <a href="<?= $_SESSION["basepath"] ?>/admin/users/toggle/<?= $user['id'] ?>" 
                                           class="btn btn-sm btn-outline-warning" 
                                           title="Inverser les droits Admin">
                                            Admin
                                        </a>
                                        <a href="<?= $_SESSION["basepath"] ?>/admin/users/delete/<?= $user['id'] ?>" 
                                           class="btn btn-sm btn-outline-danger" 
                                           onclick="return confirm('Supprimer cet utilisateur ?')"
                                           title="Supprimer">
                                            🗑️
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>