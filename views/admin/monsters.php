<main class="container my-5 text-white">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestion du Bestiaire</h2>
        <a href="<?= $_SESSION["basepath"] ?>/admin" class="btn btn-outline-light btn-sm">Retour au menu</a>
    </div>

    <div class="row">
        <div class="col-md-5">
            <div class="card bg-dark border-danger text-white mb-4">
                <div class="card-body">
                    <h5>Nouveau Monstre</h5>
                    <form action="<?= $_SESSION["basepath"] ?>/admin/createMonster" method="post">
                        <input type="text" name="name" class="form-control mb-2" placeholder="Nom" required>
                        <div class="row g-2">
                            <div class="col-6"><input type="number" name="pv" class="form-control mb-2" placeholder="PV" required></div>
                            <div class="col-6"><input type="number" name="strength" class="form-control mb-2" placeholder="Force" required></div>
                            <div class="col-6"><input type="number" name="initiative" class="form-control mb-2" placeholder="Initiative" required></div>
                            <div class="col-6"><input type="number" name="xp" class="form-control mb-2" placeholder="XP" required></div>
                        </div>
                        <input type="text" name="attack" class="form-control mb-3" placeholder="Nom de l'attaque">
                        <button type="submit" class="btn btn-danger w-100">Ajouter au bestiaire</button>
                    </form>
                </div>
            </div>

            <div class="card bg-dark border-warning text-white">
                <div class="card-body">
                    <h5>Placer un Monstre dans un Chapitre</h5>
                    <form action="<?= $_SESSION["basepath"] ?>/admin/linkMonster" method="post">
                        <select name="chapter_id" class="form-select mb-2">
                            <?php foreach($chapters as $c): ?>
                                <option value="<?= $c['id'] ?>">Chapitre: <?= $c['titre'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <select name="monster_id" class="form-select mb-3">
                            <?php foreach($monsters as $m): ?>
                                <option value="<?= $m['id'] ?>"><?= $m['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="btn btn-warning w-100">Valider l'encontre</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <table class="table table-dark border-danger">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>PV</th>
                        <th>Force</th>
                        <th>Initiative</th>
                        <th>XP</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($monsters as $m): ?>
                    <tr>
                        <td><?= htmlspecialchars($m['name']) ?></td>
                        <td><?= $m['pv'] ?></td>
                        <td><?= $m['strength'] ?></td>
                        <td><?= $m['initiative'] ?></td>
                        <td><?= $m['xp'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>