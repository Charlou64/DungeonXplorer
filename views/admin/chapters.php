<main class="container my-5 text-white">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestion des Chapitres</h2>
        <a href="<?= $_SESSION["basepath"] ?>/admin" class="btn btn-outline-light btn-sm">Retour au menu</a>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card bg-dark text-white border-light mb-4">
                <div class="card-body">
                    <h5>Nouveau Chapitre</h5>
                    <form action="<?= $_SESSION["basepath"] ?>/admin/createChapter" method="post">
                        <input type="text" name="titre" class="form-control mb-2" placeholder="Titre" required>
                        <textarea name="content" class="form-control mb-2" placeholder="Histoire..." rows="4"></textarea>
                        
                        <label class="form-label small">Illustration (/images/chapter/)</label>
                        <select name="image_select" class="form-select mb-3">
                            <option value="">Aucune</option>
                            <?php foreach($availableImages as $img): ?>
                                <option value="<?= $img ?>"><?= $img ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="btn btn-primary w-100">Enregistrer</button>
                    </form>
                </div>
            </div>
            
            <div class="card bg-dark text-white border-success">
                <div class="card-body">
                    <h5>Lier des Chapitres</h5>
                    <form action="<?= $_SESSION["basepath"] ?>/admin/addLink" method="post">
                        <label class="small">Départ</label>
                        <select name="source" class="form-select mb-2">
                            <?php foreach($chapters as $c): ?>
                                <option value="<?= $c['id'] ?>"><?= $c['titre'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label class="small">Destination</label>
                        <select name="destination" class="form-select mb-2">
                            <?php foreach($chapters as $c): ?>
                                <option value="<?= $c['id'] ?>"><?= $c['titre'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="text" name="desc" class="form-control mb-2" placeholder="Texte du bouton">
                        <button type="submit" class="btn btn-success w-100">Créer le lien</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titre</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($chapters as $ch): ?>
                    <tr>
                        <td><?= $ch['id'] ?></td>
                        <td><?= htmlspecialchars($ch['titre']) ?></td>
                        <td><small><?= $ch['image'] ?></small></td>
                        <td>
                            <a href="<?= $_SESSION["basepath"] ?>/admin/deleteChapter/<?= $ch['id'] ?>" class="btn btn-danger btn-sm">Supprimer</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>