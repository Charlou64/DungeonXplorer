<?php
class Hero
{
    public int $id;
    public string $name;
    public string $class;
    public int $pv;
    public int $mana;
    public int $strength;
    public int $initiative;
    public int $armor_bonus;
    public int $weapon_bonus;

    public static function findByUserId(PDO $db, int $userId): ?Hero
    {
        $stmt = $db->prepare("
            SELECT h.*, c.name AS class
            FROM Hero h
            JOIN Class c ON c.id = h.class_id
            WHERE h.user_id = :uid
        ");
        $stmt->execute(['uid' => $userId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) return null;

        $hero = new Hero();
        $hero->id = (int)$row['id'];
        $hero->name = $row['name'];
        $hero->class = $row['class'];
        $hero->pv = (int)$row['pv'];
        $hero->mana = (int)$row['mana'];
        $hero->strength = (int)$row['strength'];
        $hero->initiative = (int)$row['initiative'];
        // à adapter pour récupérer les bonus d’objets
        return $hero;
    }
}

?>