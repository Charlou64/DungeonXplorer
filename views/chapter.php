<?php
// $chapter fourni par le controller, $character possible depuis la session
$monsters = $chapter->getMonsters();
?>
<div class="container mt-4">
    <div class="row g-4">
        <div class="col-lg-8">
            <div style="position:relative;">
                <img src="<?php echo htmlspecialchars($chapter->getImage()); ?>" alt="Image de chapitre" style="width:100%;height:auto;border-radius:8px;object-fit:cover;">
                <div style="position:absolute;top:20px;left:20px;">
                    <h1 class="badge bg-dark" style="font-size:1.4rem;"><?php echo 'Chapitre '.$chapter->getId().' — '.htmlspecialchars($chapter->getTitle()); ?></h1>
                </div>
            </div>

            <div style="background:rgba(255,255,255,0.9); border-radius:12px; margin: 16px 0; padding: 20px; width: 100%; box-sizing: border-box;">
                <p style="color: black; font-size: 1.05rem; text-align: center; margin: 0;">
                    <?php echo nl2br(htmlspecialchars(trim($chapter->getDescription()))); ?>
                </p>
            </div>
            <!-- choix : désactivés pendant le combat -->
            <?php
                // on prépare les hrefs pour la logique JS (1er = victoire, 2e = défaite)
                $choices = $chapter->getChoices() ?: [];
                if (!empty($monsters)) {
                    $victoryHref = $defeatHref = '';
                    if (count($choices) >= 1) $victoryHref = $_SESSION['basepath'] . '/chapter/' . ((int)($choices[0]['next_chapter_id'] ?? 1));
                    if (count($choices) >= 2) $defeatHref  = $_SESSION['basepath'] . '/chapter/' . ((int)($choices[1]['next_chapter_id'] ?? 1));
                } else {
                    foreach ($choices as $c) {
                        $href = $_SESSION['basepath'] . '/chapter/' . ((int)($c['next_chapter_id'] ?? 1));
                        echo '<a class="btn btn-outline-primary me-2 mb-2 chapter-choice" href="'.$href.'">' . htmlspecialchars($c['description'] ?? 'Choix') . '</a>';
                    }
                }
            ?>
            <div id="chapter-choices" class="mt-3" aria-hidden="<?php echo !empty($monsters) ? 'true' : 'false'; ?>"></div>
        </div>

        <div class="col-lg-4">
            <?php if (!empty($monsters)): ?>
                <div class="card p-2" id="combat-panel" style="margin-bottom : 20px;" data-chapter-id="<?php echo (int)$chapter->getId(); ?>">
                    <div class="card-body"
                         data-victory-href="<?php echo htmlspecialchars($victoryHref, ENT_QUOTES, 'UTF-8'); ?>"
                         data-defeat-href="<?php echo htmlspecialchars($defeatHref, ENT_QUOTES, 'UTF-8'); ?>">
                         <h5 class="card-title">Combat</h5>

                        <!-- joueur -->
                        <div id="player-card" class="mb-3 p-2" style="border-radius:8px;background:#f8f9fa;color:black;">
                            <?php if ($character): ?>
                                <div><strong><?php echo htmlspecialchars($character->getName()); ?></strong> (Niv <?php echo (int)$character->getCurrentLevel(); ?>)</div>
                                <div>PV: <span id="player-hp" style="color:black;"><?php echo (int)$character->getPv(); ?></span> / <?php echo (int)$character->getPv(); ?></div>
                                <div>Mana: <span id="player-mana" style="color:black;"><?php echo (int)$character->getMana(); ?></span> / <?php echo (int)$character->getMana(); ?></div>
                                <div>Force: <span id="player-str" style="color:black;"><?php echo (int)$character->getStrength(); ?></span></div>
                                <input type="hidden" id="player-id" value="<?php echo (int)$character->getId(); ?>">
                            <?php else: ?>
                                <div class="text-danger">Aucun personnage sélectionné. Utilisez "Continuer l'aventure" depuis la liste pour choisir un personnage.</div>
                            <?php endif; ?>
                        </div>

                        <!-- monstres -->
                        <div id="monsters-list" class="mb-2" style="color:black;">
                            <?php foreach ($monsters as $i => $m): ?>
                                <div class="mb-2 p-2 monster-row" data-index="<?php echo $i; ?>"
                                     data-id="<?php echo (int)$m->getId(); ?>"
                                     data-hp="<?php echo (int)$m->getPv(); ?>"
                                     data-maxhp="<?php echo (int)$m->getPv(); ?>"
                                     data-str="<?php echo (int)$m->getStrength(); ?>"
                                     data-init="<?php echo (int)$m->getInitiative(); ?>"
                                     style="border-radius:8px;background:#fff;border:1px solid rgba(0,0,0,0.06);">
                                    <div style="display:flex;justify-content:space-between;align-items:center">
                                        <strong><?php echo htmlspecialchars($m->getName()); ?></strong>
                                        <small>Init: <?php echo (int)$m->getInitiative(); ?></small>
                                    </div>
                                    <div class="mt-1">PV: <span class="monster-hp" style="color:black;"><?php echo (int)$m->getPv(); ?></span> / <?php echo (int)$m->getPv(); ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- actions -->
                        <div id="combat-actions" class="d-grid gap-2">
                            <button id="action-attack" class="btn btn-danger" <?php echo $character ? '' : 'disabled'; ?>>Attaquer</button>
                            <button id="action-defend" class="btn btn-secondary" <?php echo $character ? '' : 'disabled'; ?>>Se protéger</button>
                            <button id="action-potion" class="btn btn-warning" <?php echo $character ? '' : 'disabled'; ?>>Potion</button>
                        </div>

                        <!-- log -->
                        <div id="combat-log" style="height:220px; overflow:auto; margin-top:12px; background:#000; color:#fff; padding:8px; border-radius:6px; font-size:0.9rem;"></div>
                    </div>
                </div>
            <?php else: ?>
                <div class="card p-2">
                    <div class="card-body">
                        <h5 class="card-title">Aucun combat</h5>
                        <p>Il n'y a pas d'ennemis dans ce chapitre.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- script de combat minimal : si tu veux externaliser place dans public/js/fight.js -->
<script>
(function(){
    const monstersEl = document.getElementById('monsters-list');
    if (!monstersEl) return;

    // build state
    const player = {
        id: document.getElementById('player-id') ? +document.getElementById('player-id').value : null,
        name: document.querySelector('#player-card strong') ? document.querySelector('#player-card strong').textContent : 'Héros',
        hp: document.getElementById('player-hp') ? +document.getElementById('player-hp').textContent : 0,
        maxhp: document.getElementById('player-hp') ? +document.getElementById('player-hp').textContent : 0,
        mana: document.getElementById('player-mana') ? +document.getElementById('player-mana').textContent : 0,
        str: document.getElementById('player-str') ? +document.getElementById('player-str').textContent : 1,
        defend: false,
    };

    const monsters = Array.from(document.querySelectorAll('.monster-row')).map(el => ({
        el,
        index: +el.dataset.index,
        id: +el.dataset.id,
        name: el.querySelector('strong').textContent,
        hp: +el.dataset.hp,
        maxhp: +el.dataset.maxhp,
        str: +el.dataset.str,
        init: +el.dataset.init,
        alive: +el.dataset.hp > 0
    }));

    const logEl = document.getElementById('combat-log');
    const choicesEls = document.querySelectorAll('.chapter-choice');

    function log(txt){
        const time = new Date().toLocaleTimeString();
        logEl.innerHTML = '<div>['+time+'] '+txt+'</div>' + logEl.innerHTML;
    }

    function disableChoices(v){
        choicesEls.forEach(a => a.style.pointerEvents = v ? 'none' : '');
        choicesEls.forEach(a => a.style.opacity = v ? '0.5' : '1');
    }

    // turn order: sort by initiative
    let turnOrder = [];
    function computeOrder(){
        turnOrder = [];
        // push player
        turnOrder.push({type:'player', init: player.str + (player.mana||0) +  (Math.random()*5)});
        monsters.forEach(m => { if (m.alive) turnOrder.push({type:'monster', index: m.index, init: m.init + Math.random()*5}); });
        turnOrder.sort((a,b)=> b.init - a.init);
    }

    function updateUI(){
        // update player
        const php = document.getElementById('player-hp');
        if (php) php.textContent = Math.max(0, player.hp);
        const pm = document.getElementById('player-mana');
        if (pm) pm.textContent = Math.max(0, player.mana);

        // monsters
        monsters.forEach(m=>{
            const hpEl = m.el.querySelector('.monster-hp');
            if (hpEl) hpEl.textContent = Math.max(0, m.hp);
            if (!m.alive || m.hp <= 0) {
                m.alive = false;
                m.el.style.opacity = 0.45;
                m.el.style.textDecoration = 'line-through';
            }
        });
    }

    function allMonstersDead(){ return monsters.every(m=>!m.alive); }

    function endCombat(victory){
        document.getElementById('action-attack').disabled = true;
        document.getElementById('action-defend').disabled = true;
        document.getElementById('action-potion').disabled = true;
        if (victory) {
            log('Victoire ! Les choix du chapitre sont à nouveau disponibles.');
            // TODO: optionnel : POST pour enregistrer récompenses / Hero_Progression
        } else {
            log('Défaite... rechargez une sauvegarde ou revenez à la liste.');
        }

        // afficher dynamiquement le choix approprié (même logique que le PHP entre les lignes 21-43)
        (function renderChoice() {
            const panel = document.getElementById('combat-panel');
            const body = panel ? panel.querySelector('.card-body') : null;
            const victoryHref = body ? body.dataset.victoryHref : '';
            const defeatHref = body ? body.dataset.defeatHref : '';
            const container = document.getElementById('chapter-choices');
            if (!container) return;

            // vider l'ancien contenu
            container.innerHTML = '';
            container.style.display = ''; // rendre visible
            container.setAttribute('aria-hidden', 'false');

            // choix selon l'état actuel du joueur / monstres (même principe que le PHP)
            let chosenHref = '';
            if (player.hp <= 0) {
                chosenHref = defeatHref;
            } else {
                // si il reste des monstres vivants, on ne propose pas de choix
                const anyAlive = monsters.some(m => m.alive && m.hp > 0);
                if (!anyAlive) chosenHref = victoryHref;
            }

            if (chosenHref) {
                const a = document.createElement('a');
                a.className = 'btn btn-outline-primary me-2 mb-2 chapter-choice';
                a.href = chosenHref;
                a.textContent = victory ? 'Continuer (Victoire)' : 'Continuer (Défaite)';
                container.appendChild(a);
            }
        })();
    }

    // monster AI simple : attack player
    function monsterAction(mon){
        if (!mon.alive) return;
        const dmg = Math.max(1, mon.str + Math.floor(Math.random()*4));
        const actual = player.defend ? Math.max(0, Math.floor(dmg/2)) : dmg;
        player.hp -= actual;
        player.defend = false;
        log(mon.name + ' attaque et inflige ' + actual + ' dégâts.');
        if (player.hp <= 0) {
            player.hp = 0;
            updateUI();
            log('Le héros est tombé.');
            endCombat(false);
            return true;
        }
        updateUI();
        return false;
    }

    // player attack action (target first alive by default)
    function playerAttack(){
        const target = monsters.find(m=>m.alive);
        if (!target) { log('Aucun ennemi ciblable'); return; }
        const dmg = Math.max(1, player.str + Math.floor(Math.random()*4));
        target.hp -= dmg;
        if (target.hp <= 0) {
            target.hp = 0;
            target.alive = false;
            log(player.name + ' attaque ' + target.name + ' et le met K.O. ('+dmg+' dmg)');
        } else {
            log(player.name + ' attaque ' + target.name + ' ('+dmg+' dmg)');
        }
        updateUI();
    }

    // simple turn loop
    async function runCombatLoop(){
        disableChoices(true);
        document.getElementById('action-attack').disabled = true;
        document.getElementById('action-defend').disabled = true;
        document.getElementById('action-potion').disabled = true;
        computeOrder();
        log('Combat démarré — initiative calculée.');
        for(;;){
            if (allMonstersDead()) { endCombat(true); break; }
            if (player.hp <= 0) { endCombat(false); break; }

            for (const t of turnOrder){
                if (t.type === 'player'){
                    // player turn: enable buttons and wait for action
                    if (player.hp <= 0) break;
                    document.getElementById('action-attack').disabled = false;
                    document.getElementById('action-defend').disabled = false;
                    document.getElementById('action-potion').disabled = false;
                    log("C'est votre tour.");
                    // wait for action chosen (promise)
                    await new Promise(resolve=>{
                        const a1 = document.getElementById('action-attack');
                        const a2 = document.getElementById('action-defend');
                        const a3 = document.getElementById('action-potion');

                        function clean(){ a1.removeEventListener('click',onA1); a2.removeEventListener('click',onA2); a3.removeEventListener('click',onA3); }
                        function onA1(e){ clean(); playerAttack(); resolve(); }
                        function onA2(e){ clean(); player.defend = true; log(player.name + ' prend une posture défensive (dégâts /2 pour ce tour).'); resolve(); }
                        function onA3(e){ clean(); player.hp = Math.min(player.maxhp, player.hp + 20); log(player.name + ' boit une potion et récupère 20 PV.'); updateUI(); resolve(); }

                        a1.addEventListener('click', onA1);
                        a2.addEventListener('click', onA2);
                        a3.addEventListener('click', onA3);
                    });
                    // after player action disable buttons briefly
                    document.getElementById('action-attack').disabled = true;
                    document.getElementById('action-defend').disabled = true;
                    document.getElementById('action-potion').disabled = true;
                } else if (t.type === 'monster') {
                    const mon = monsters.find(m=>m.index === t.index);
                    if (!mon || !mon.alive) continue;
                    const dead = monsterAction(mon);
                    if (dead) return;
                }
                // recompute order mid-combat if many dynamics? keep simple: same round order
                if (allMonstersDead()) { endCombat(true); return; }
            }
            // recompute order for next round (initiative jitter)
            computeOrder();
        }
    }

    // attach actions initial -> start loop immediately when view loaded
    if (monsters.length > 0 && player.hp > 0) {
        updateUI();
        // start loop
        runCombatLoop();
    } else {
        // no monsters or no player
    }
})();
</script>