<main class="container my-5">
    <h1 class="text-white mb-4">Administration de l'Aventure</h1>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card bg-dark text-white border-light">
                <div class="card-body">
                    <h5>Nouveau Chapitre</h5>
                    <form action="<?= $_SESSION["basepath"] ?>/admin/createChapter" method="post">
                        <div class="mb-2">
                            <label class="form-label">Titre</label>
                            <input type="text" name="titre" class="form-control" required>
                        </div>
                        
                        <div class="mb-2">
                            <label class="form-label">Histoire</label>
                            <textarea name="content" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Choisir une image</label>
                            <select name="image_select" id="imageSelector" class="form-select" onchange="updatePreview()">
                                <option value="">-- Sélectionner une image --</option>
                                <?php foreach($availableImages as $img): ?>
                                    <option value="<?= $img ?>"><?= $img ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3 text-center">
                            <img id="preview" src="" style="max-width: 100%; height: 100px; display: none; border-radius: 5px;">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Créer le chapitre</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card bg-dark text-white border-light">
                <div class="card-body">
                    <h5>Lier deux chapitres</h5>
                    <form action="<?= $_SESSION["basepath"] ?>/admin/addLink" method="post">
                        <select name="source" class="form-select mb-2">
                            <?php foreach($chapters as $c): ?>
                                <option value="<?= $c['id'] ?>">De : <?= $c['titre'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <select name="destination" class="form-select mb-2">
                            <?php foreach($chapters as $c): ?>
                                <option value="<?= $c['id'] ?>">Vers : <?= $c['titre'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="text" name="desc" class="form-control mb-2" placeholder="Texte du bouton (ex: Ouvrir la porte)">
                        <button type="submit" class="btn btn-success w-100">Créer le lien</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <table class="table table-dark table-striped mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($chapters as $chapter): ?>
            <tr>
                <td><?= $chapter['id'] ?></td>
                <td><?= htmlspecialchars($chapter['titre']) ?></td>
                <td>
                    <a href="<?= $_SESSION["basepath"] ?>/admin/deleteChapter/<?= $chapter['id'] ?>" 
                       class="btn btn-sm btn-danger" 
                       onclick="return confirm('Supprimer ce chapitre ?')">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>