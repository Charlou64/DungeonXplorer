<?php

class MonsterModel
{
    private $id;
    private $name;
    private $pv;
    private $mana;
    private $initiative;
    private $strength;
    private $attack; // texte décrivant l'attaque / comportement
    private $xp;

    public function __construct(array $data = [])
    {
        $this->id = isset($data['id']) ? (int)$data['id'] : null;
        $this->name = $data['name'] ?? '';
        $this->pv = isset($data['pv']) ? (int)$data['pv'] : 0;
        $this->mana = isset($data['mana']) ? (int)$data['mana'] : null;
        $this->initiative = isset($data['initiative']) ? (int)$data['initiative'] : 0;
        $this->strength = isset($data['strength']) ? (int)$data['strength'] : 0;
        $this->attack = $data['attack'] ?? null;
        $this->xp = isset($data['xp']) ? (int)$data['xp'] : 0;
    }

    public static function fromRow(array $row)
    {
        return new self($row);
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'pv' => $this->pv,
            'mana' => $this->mana,
            'initiative' => $this->initiative,
            'strength' => $this->strength,
            'attack' => $this->attack,
            'xp' => $this->xp,
        ];
    }

    // sauvegarde (INSERT / UPDATE). $bdd = PDO
    public function save(PDO $bdd)
    {
        try {
            $data = $this->toArray();

            if ($this->id) {
                $sql = "UPDATE `Monster` SET
                    name = :name,
                    pv = :pv,
                    mana = :mana,
                    initiative = :initiative,
                    strength = :strength,
                    attack = :attack,
                    xp = :xp
                    WHERE id = :id
                ";
                $stmt = $bdd->prepare($sql);
                $stmt->execute([
                    ':name' => $data['name'],
                    ':pv' => $data['pv'],
                    ':mana' => $data['mana'],
                    ':initiative' => $data['initiative'],
                    ':strength' => $data['strength'],
                    ':attack' => $data['attack'],
                    ':xp' => $data['xp'],
                    ':id' => $this->id
                ]);
                return true;
            } else {
                $sql = "INSERT INTO `Monster` (name, pv, mana, initiative, strength, attack, xp)
                        VALUES (:name, :pv, :mana, :initiative, :strength, :attack, :xp)";
                $stmt = $bdd->prepare($sql);
                $stmt->execute([
                    ':name' => $data['name'],
                    ':pv' => $data['pv'],
                    ':mana' => $data['mana'],
                    ':initiative' => $data['initiative'],
                    ':strength' => $data['strength'],
                    ':attack' => $data['attack'],
                    ':xp' => $data['xp']
                ]);
                $this->id = (int)$bdd->lastInsertId();
                return true;
            }
        } catch (PDOException $e) {
            // en dev : error_log($e->getMessage());
            return false;
        }
    }

    // getters / setters
    public function getId() { return $this->id; }
    public function setId($v) { $this->id = $v === null ? null : (int)$v; }

    public function getName() { return $this->name; }
    public function setName($v) { $this->name = $v; }

    public function getPv() { return $this->pv; }
    public function setPv($v) { $this->pv = (int)$v; }

    public function getMana() { return $this->mana; }
    public function setMana($v) { $this->mana = $v === null ? null : (int)$v; }

    public function getInitiative() { return $this->initiative; }
    public function setInitiative($v) { $this->initiative = (int)$v; }

    public function getStrength() { return $this->strength; }
    public function setStrength($v) { $this->strength = (int)$v; }

    public function getAttack() { return $this->attack; }
    public function setAttack($v) { $this->attack = $v; }

    public function getXp() { return $this->xp; }
    public function setXp($v) { $this->xp = (int)$v; }
}
