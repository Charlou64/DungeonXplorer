<?php

require_once __DIR__ . '/fight/MonsterModel.php';

class Chapter
{
    private $id;
    private $title;
    private $description;
    private $image;
    private $choices;

    // nouveau : liste d'objets MonsterModel
    private $monsters = [];

    /**
     * Conserver constructeur existant ; $choices et $monsters peuvent être fournis
     */
    public function __construct($id, $title, $description, $image, $choices = [], array $monsters = [])
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->image = $image;
        $this->choices = $choices;
        $this->monsters = $monsters;
    }

    // --- getters existants ---
    public function getId()        { return $this->id; }
    public function getTitle()     { return $this->title; }
    public function getDescription(){ return $this->description; }
    public function getImage()     { return $this->image; }
    public function getChoices()   { return $this->choices; }

    // --- nouveaux accesseurs pour les monstres ---
    /**
     * Retourne un tableau d'objets MonsterModel
     */
    public function getMonsters(): array
    {
        return $this->monsters;
    }

    /**
     * Remplace la liste de monstres (attend des MonsterModel)
     */
    public function setMonsters(array $monsters)
    {
        $this->monsters = $monsters;
    }

    /**
     * Ajoute un MonsterModel à la liste
     */
    public function addMonster(MonsterModel $monster)
    {
        $this->monsters[] = $monster;
    }

    // --- utilitaires de construction / chargement ---

    /**
     * Crée un Chapter depuis une ligne (array). Accepte :
     * - choices en JSON ou array
     * - monsters en JSON (tableau d'objets) ou array de rows => transformés en MonsterModel
     */
    public static function fromRow(array $row)
    {
        $choices = $row['choices'] ?? [];
        if (is_string($choices) && $choices !== '') {
            $decoded = json_decode($choices, true);
            if (is_array($decoded)) $choices = $decoded;
        }

        $monsters = [];
        if (isset($row['monsters'])) {
            $m = $row['monsters'];
            if (is_string($m) && $m !== '') {
                $decoded = json_decode($m, true);
                if (is_array($decoded)) {
                    foreach ($decoded as $mr) {
                        if (is_array($mr)) $monsters[] = MonsterModel::fromRow($mr);
                    }
                }
            } elseif (is_array($m)) {
                // si déjà un tableau de lignes/rows
                foreach ($m as $mr) {
                    if (is_array($mr)) $monsters[] = MonsterModel::fromRow($mr);
                }
            }
        }

        return new self(
            $row['id'] ?? null,
            $row['title'] ?? ($row['name'] ?? ''),
            $row['description'] ?? null,
            $row['image'] ?? null,
            $choices,
            $monsters
        );
    }

    /**
     * Charge depuis la base les monstres liés à ce chapitre.
     * Essaie plusieurs schémas possibles : table de liaison (Encounter ou Chapter_Monster)
     * puis fallback sur colonne chapter_id dans Monster.
     */
    public function loadMonsters(PDO $bdd)
    {
        if (!$this->id) {
            $this->monsters = [];
            return $this->monsters;
        }

        $rows = [];

        // liste des requêtes à tenter dans l'ordre (table/colonne différentes selon dump)
        $queries = [
            // table de jonction nommée Encounter (utilisé dans le projet)
            "SELECT m.* FROM `Monster` m JOIN `Encounter` en ON en.monster_id = m.id WHERE en.chapter_id = :cid",
            // alternative courante : Chapter_Monster
            "SELECT m.* FROM `Monster` m JOIN `Chapter_Monster` cm ON cm.monster_id = m.id WHERE cm.chapter_id = :cid",
            // fallback : colonne chapter_id dans Monster
            "SELECT m.* FROM `Monster` m WHERE m.chapter_id = :cid"
        ];

        foreach ($queries as $sql) {
            try {
                $stmt = $bdd->prepare($sql);
                if ($stmt && $stmt->execute([':cid' => $this->id])) {
                    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
            } catch (PDOException $e) {
                // ignore and essayer la requête suivante
                if (defined('DEBUG') && DEBUG) {
                    error_log('loadMonsters query failed: ' . $e->getMessage());
                }
                $rows = [];
            }

            if (!empty($rows)) break;
        }

        $monsters = [];
        foreach ($rows as $r) {
            $monsters[] = MonsterModel::fromRow($r);
        }

        $this->monsters = $monsters;
        return $this->monsters;
    }
}
