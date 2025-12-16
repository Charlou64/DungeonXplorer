<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h1 class="h3 mb-3">Créer un personnage</h1>

            <form action="<?php echo $_SESSION['basepath'] ?? ''; ?>/character/create" method="post" id="character-creation-form">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Nom du personnage</label>
                        <input type="text" id="name" name="name" class="form-control" required maxlength="50" placeholder="Entrez le nom">
                    </div>

                    <div class="col-md-6">
                        <label for="class-select" class="form-label">Classe</label>
                        <select id="class-select" name="class" class="form-select" required>
                            <option value="">Choisissez une classe</option>
                            <option value="1">Guerrier</option>
                            <option value="2">Voleur</option>
                            <option value="3">Magicien</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <?php
                        // liste les images du dossier images/character pour le menu déroulant
                        $imgDir = __DIR__ . '/../../images/character';
                        $images = [];
                        if (is_dir($imgDir)) {
                            $files = scandir($imgDir);
                            foreach ($files as $f) {
                                if ($f === '.' || $f === '..') continue;
                                $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
                                if (in_array($ext, ['png','jpg','jpeg','gif','webp'])) {
                                    $images[] = $f;
                                }
                            }
                        }
                        $basePath = $_SESSION['basepath'] ?? '';
                        ?>
                        <label for="image-select" class="form-label">Image</label>
                        <select id="image-select" name="image" class="form-select mb-2">
                            <option value="">Aucune / par défaut</option>
                            <?php foreach ($images as $img): ?>
                                <option value="<?php echo htmlspecialchars($basePath . '/images/character/' . $img, ENT_QUOTES, 'UTF-8'); ?>">
                                    <?php echo htmlspecialchars($img, ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6 d-flex flex-column align-items-start">
                        <label class="form-label">Aperçu</label>

                        <style>
                            /* agrandi et rendu responsive : carré maintenu via aspect-ratio */
                            .avatar-frame {
                                width:100%;
                                max-width:450px; 
                                aspect-ratio: 1 / 1;
                                overflow:hidden;
                                border-radius:10px;
                                border:1px solid #e5e7eb;
                                background:#fff;
                            }
                            .avatar-frame img {
                                width:100%;
                                height:100%;
                                object-fit:cover;
                                display:block;
                            }
                        </style>

                        <div class="avatar-frame mb-2">
                            <img id="avatar-preview" src="<?php echo $basePath; ?>/images/rien.jpg" alt="aperçu avatar">
                        </div>
                        <small class="text-muted">Sélectionnez une image dans la liste. Seules les images du dossier images/character sont autorisées.</small>
                    </div>

                    <script>
                        (function(){
                            const select = document.getElementById('image-select');
                            const preview = document.getElementById('avatar-preview');
                            const defaultSrc = '<?php echo $basePath; ?>/images/rien.jpg';

                            function setPreview(src){
                                preview.src = src && src.length ? src : defaultSrc;
                            }

                            select?.addEventListener('change', function(){
                                setPreview(this.value);
                            });

                            // initial preview si une option est pré-sélectionnée
                            setPreview(select?.value || defaultSrc);
                            preview.addEventListener('error', function(){ preview.src = defaultSrc; });
                        })();
                    </script>

                    <div class="col-12">
                        <label for="biography" class="form-label">Biographie</label>
                        <textarea id="biography" name="biography" class="form-control" rows="4" placeholder="Décrivez votre héros..."></textarea>
                    </div>

                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="fw-bold">Caractéristiques</div>
                            <div>
                                <button type="button" id="reroll" class="btn btn-outline-secondary btn-sm">
                                    <i class="fa fa-dice"></i> Relancer
                                </button>
                            </div>
                        </div>

                        <div class="row g-2">
                            <div class="col-sm-3">
                                <div class="p-2 bg-white border rounded text-center">
                                    <div class="text-muted small">PV</div>
                                    <div id="hp" class="stat-box">0</div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="p-2 bg-white border rounded text-center">
                                    <div class="text-muted small">Mana</div>
                                    <div id="mana" class="stat-box">0</div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="p-2 bg-white border rounded text-center">
                                    <div class="text-muted small">Force</div>
                                    <div id="stren" class="stat-box">0</div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="p-2 bg-white border rounded text-center">
                                    <div class="text-muted small">Initiative</div>
                                    <div id="init" class="stat-box">0</div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="p-2 bg-white border rounded text-center">
                                    <div class="text-muted small">Équipement</div>
                                    <div id="stuff" class="stat-box">0</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- champs cachés envoyés au serveur -->
                    <input type="hidden" name="pv" id="pv-input" value="0">
                    <input type="hidden" name="mana_val" id="mana-input" value="0">
                    <input type="hidden" name="strength_val" id="str-input" value="0">
                    <input type="hidden" name="initiative_val" id="init-input" value="0">
                    <input type="hidden" name="stuff_val" id="stuff-input" value="0">

                    <div class="col-12 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Créer le personnage</button>
                        <a href="<?php echo $_SESSION['basepath'] ?? ''; ?>/character" class="btn btn-outline-secondary">Annuler</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <p class="text-muted small mt-3">Astuce : utilisez le bouton "Relancer" pour obtenir d'autres valeurs de caractéristiques avant de créer le personnage.</p>
</div>

<!-- Font Awesome si besoin -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js" defer></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>

<script>
const classStatsRaw = <?php echo json_encode($classes, JSON_NUMERIC_CHECK); ?>;

document.addEventListener('DOMContentLoaded', () => {
    const classSelect = document.getElementById('class-select');
    const rerollBtn = document.getElementById('reroll');

    const statsBox = {
        hp: document.getElementById('hp'),
        mana: document.getElementById('mana'),
        str: document.getElementById('stren'),
        init: document.getElementById('init'),
        stuff: document.getElementById('stuff')
    };

    const inputs = {
        hp: document.getElementById('pv-input'),
        mana: document.getElementById('mana-input'),
        str: document.getElementById('str-input'),
        init: document.getElementById('init-input'),
        stuff: document.getElementById('stuff-input')
    };

    // Mise en forme des stats par id de classe
    const classStats = {};
    classStatsRaw.forEach(c => {
        classStats[c.id] = {
            pv: c.base_pv,
            mana: c.base_mana,
            str: c.strength,
            init: c.initiative,
            stuff: c.max_items
        };
    });

    const rand = (min, max) => Math.floor(Math.random() * (max - min + 1)) + min;

    function applyStats(s) {
        statsBox.hp.textContent = s.pv;
        statsBox.mana.textContent = s.mana;
        statsBox.str.textContent = s.str;
        statsBox.init.textContent = s.init;
        statsBox.stuff.textContent = s.stuff;

        inputs.hp.value = s.pv;
        inputs.mana.value = s.mana;
        inputs.str.value = s.str;
        inputs.init.value = s.init;
        inputs.stuff.value = s.stuff;
    }

    function reroll() {
        const id = classSelect.value;
        if (!classStats[id]) return;

        const b = classStats[id];

        applyStats({
            pv: b.pv + rand(-10, 10),
            mana: b.mana + rand(0, 5),
            str: b.str + rand(-2, 2),
            init: b.init + rand(-2, 2),
            stuff: b.stuff
        });
    }

    rerollBtn.addEventListener('click', e => {
        e.preventDefault();
        reroll();
    });

    classSelect.addEventListener('change', reroll);
});
</script>
