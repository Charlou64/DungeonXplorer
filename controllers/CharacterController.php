<?php
class CharacterController {

    private $characters = [];

    public function index() {
        global $bdd;

        // assure que le modèle Character, Class et Item sont disponibles
        require_once 'models/characterModel.php';
        require_once 'models/classModel.php';
        require_once 'models/ItemModel.php';

        if (!isset($_SESSION["username"])) {
            header('Location: ' . ($_SESSION['basepath'] ?? '') . '/account/signIn');
            exit;
        }

        // Récupération des infos des personnages + informations de la classe
        $sql = "
            SELECT h.*,
                   c.id AS class_id,
                   c.name AS class_name,
                   c.description AS class_description,
                   c.base_pv AS class_base_pv,
                   c.base_mana AS class_base_mana,
                   c.strength AS class_strength,
                   c.initiative AS class_initiative,
                   c.max_items AS class_max_items
            FROM Hero AS h
            LEFT JOIN Class AS c ON h.class_id = c.id
            JOIN Users AS u ON h.compte_id = u.id
            WHERE u.username = :username
        ";
        $stmt = $bdd->prepare($sql);
        $stmt->execute([':username' => $_SESSION['username']]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->characters = [];
        foreach ($rows as $row) {
            // construire l'objet Character depuis la ligne
            $character = Character::fromRow($row);

            // attacher la ClassModel si présente
            if (!empty($row['class_id'])) {
                $classData = [
                    'id' => $row['class_id'],
                    'name' => $row['class_name'] ?? '',
                    'description' => $row['class_description'] ?? null,
                    'base_pv' => $row['class_base_pv'] ?? 0,
                    'base_mana' => $row['class_base_mana'] ?? 0,
                    'strength' => $row['class_strength'] ?? 0,
                    'initiative' => $row['class_initiative'] ?? 0,
                    'max_items' => $row['class_max_items'] ?? 0,
                ];
                $character->setClass(ClassModel::fromRow($classData));
            } else {
                $character->setClass(new ClassModel([]));
            }

            // charger équipements (Items) si présents
            $this->attachItemIfExists($character, 'armor_item_id', 'setArmorItem', $bdd);
            $this->attachItemIfExists($character, 'primary_weapon_item_id', 'setPrimaryWeaponItem', $bdd);
            $this->attachItemIfExists($character, 'secondary_weapon_item_id', 'setSecondaryWeaponItem', $bdd);
            $this->attachItemIfExists($character, 'shield_item_id', 'setShieldItem', $bdd);

            $this->characters[] = $character;
        }

        $characters = $this->characters;

        require_once 'views/character/character.php';
    }

    public function create()
    {
        global $bdd;

        // sécurité
        if (!isset($_SESSION["username"])) {
            header('Location: ' . ($_SESSION['basepath'] ?? '') . '/account/signIn');
            exit;
        }

        // ─────────────────────────────────────────────
        // POST → insertion du personnage
        // ─────────────────────────────────────────────
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // récupération utilisateur
            $stmt = $bdd->prepare("SELECT id FROM Users WHERE username = :u LIMIT 1");
            $stmt->execute([':u' => $_SESSION['username']]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                throw new Exception("Utilisateur introuvable");
            }

            // données formulaire
            $name       = trim($_POST['name']);
            $classId    = (int)$_POST['class'];
            $image      = !empty($_POST['image']) ? trim($_POST['image']) : null;
            $biography  = trim($_POST['biography']);

            // stats envoyées
            $pv         = (int)$_POST['pv'];
            $mana       = (int)$_POST['mana_val'];
            $strength   = (int)$_POST['strength_val'];
            $initiative = (int)$_POST['initiative_val'];

            // récupération des stats de base de la classe (ANTI-TRICHE)
            $stmt = $bdd->prepare("
                SELECT base_pv, base_mana, strength, initiative
                FROM Class
                WHERE id = :id
                LIMIT 1
            ");
            $stmt->execute([':id' => $classId]);
            $class = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$class) {
                throw new Exception("Classe invalide");
            }

            // vérification simple des bornes (tolérance reroll)
            if (
                abs($pv - $class['base_pv']) > 15 ||
                abs($mana - $class['base_mana']) > 10 ||
                abs($strength - $class['strength']) > 5 ||
                abs($initiative - $class['initiative']) > 5
            ) {
                throw new Exception("Tentative de triche détectée");
            }

            // insertion du personnage
            $stmt = $bdd->prepare("
                INSERT INTO Hero (
                    name, compte_id, class_id, image, biography,
                    pv, mana, strength, initiative
                ) VALUES (
                    :name, :compte, :class, :image, :bio,
                    :pv, :mana, :str, :init
                )
            ");

            $stmt->execute([
                ':name'   => $name,
                ':compte'=> $user['id'],
                ':class' => $classId,
                ':image' => $image,
                ':bio'   => $biography,
                ':pv'    => $pv,
                ':mana'  => $mana,
                ':str'   => $strength,
                ':init'  => $initiative
            ]);

            // redirection
            header('Location: ' . ($_SESSION['basepath'] ?? '') . '/character');
            exit;
        }

        // ─────────────────────────────────────────────
        // GET → affichage du formulaire
        // ─────────────────────────────────────────────
        $classes = $bdd->query("
            SELECT id, base_pv, base_mana, strength, initiative, max_items
            FROM Class
        ")->fetchAll(PDO::FETCH_ASSOC);

        require_once 'views/character/characterCreation.php';
    }

    public function show($id) {
        global $bdd;

        // assure que le modèle Character et Class sont disponibles
        require_once 'models/characterModel.php';
        require_once 'models/classModel.php';
        require_once 'models/ItemModel.php';

        if (!isset($_SESSION["username"])) {
            header('Location: ' . ($_SESSION['basepath'] ?? '') . '/account/signIn');
            exit;
        }

        // Récupération du personnage (vérifie que le personnage appartient bien à l'utilisateur)
        $sql = "
            SELECT h.*,
                   c.id AS class_id,
                   c.name AS class_name,
                   c.description AS class_description,
                   c.base_pv AS class_base_pv,
                   c.base_mana AS class_base_mana,
                   c.strength AS class_strength,
                   c.initiative AS class_initiative,
                   c.max_items AS class_max_items
            FROM Hero AS h
            LEFT JOIN Class AS c ON h.class_id = c.id
            JOIN Users AS u ON h.compte_id = u.id
            WHERE u.username = :username
              AND h.id = :id
            LIMIT 1
        ";
        $stmt = $bdd->prepare($sql);
        $stmt->execute([
            ':username' => $_SESSION['username'],
            ':id' => $id
        ]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            // pas trouvé ou pas autorisé
            require_once 'views/404.php';
            return;
        }

        // construire l'objet Character et attacher la ClassModel (même si vide)
        $character = Character::fromRow($row);
        if (!empty($row['class_id'])) {
            $classData = [
                'id' => $row['class_id'],
                'name' => $row['class_name'] ?? '',
                'description' => $row['class_description'] ?? null,
                'base_pv' => $row['class_base_pv'] ?? 0,
                'base_mana' => $row['class_base_mana'] ?? 0,
                'strength' => $row['class_strength'] ?? 0,
                'initiative' => $row['class_initiative'] ?? 0,
                'max_items' => $row['class_max_items'] ?? 0,
            ];
            $character->setClass(ClassModel::fromRow($classData));
        } else {
            $character->setClass(new ClassModel([]));
        }

        // attacher équipements (Items)
        $this->attachItemIfExists($character, 'armor_item_id', 'setArmorItem', $bdd);
        $this->attachItemIfExists($character, 'primary_weapon_item_id', 'setPrimaryWeaponItem', $bdd);
        $this->attachItemIfExists($character, 'secondary_weapon_item_id', 'setSecondaryWeaponItem', $bdd);
        $this->attachItemIfExists($character, 'shield_item_id', 'setShieldItem', $bdd);

        // fournir la compatibilité vue (optionnel)
        $this->characters = [$character];
        $characters = $this->characters;

        require_once 'views/character/view_character.php';
    }

    public function getCharacter($id)
    {
        foreach ($this->characters as $character) {
            if ($character->getId() == $id) {
                return $character;
            }
        }
        return null; // Character non trouvé
    }

    // helper pour charger un ItemModel si l'ID est présent sur le Character
    private function attachItemIfExists($character, $idFieldName, $setterName, $bdd)
    {
        $id = $character->{$idFieldName} ?? null;
        if ($id) {
            $stmt = $bdd->prepare("SELECT * FROM Items WHERE id = :id LIMIT 1");
            $stmt->execute([':id' => $id]);
            $itemRow = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($itemRow) {
                $itemObj = ItemModel::fromRow($itemRow);
                $character->{$setterName}($itemObj);
            }
        }
    }
}