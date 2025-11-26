//TODO

<?php

class Monster
{
    public int $id;
    public string $name;
    public int $pv;
    public ?int $mana;
    public int $strength;
    public int $initiative;

    public static function findById(PDO $db, int $id): ?Monster
    {
        $stmt = $db->prepare("SELECT * FROM Monster WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) return null;

        $m = new self();
        $m->id         = (int)$row['id'];
        $m->name       = $row['name'];
        $m->pv         = (int)$row['pv'];
        $m->mana       = $row['mana'] !== null ? (int)$row['mana'] : null;
        $m->strength   = (int)$row['strength'];
        $m->initiative = (int)$row['initiative'];
        return $m;
    }
}

?>