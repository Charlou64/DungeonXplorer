<?php

class Character
{
    private $id;
    private $name;
    private $compte_id;
    private $class_id;
    private $class; // <-- objet ClassModel
    private $image;
    private $biography;
    private $pv;
    private $mana;
    private $strength;
    private $initiative;
    private $armor_item_id;
    private $primary_weapon_item_id;
    private $secondary_weapon_item_id;
    private $shield_item_id;

    // nouveaux objets ItemModel attachés
    private $armor_item;
    private $primary_weapon_item;
    private $secondary_weapon_item;
    private $shield_item;

    private $spell_list; // stocké en interne comme tableau
    private $xp;
    private $current_level;

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'] ?? '';
        $this->compte_id = $data['compte_id'] ?? null;
        $this->class_id = $data['class_id'] ?? null;
        $this->class = $data['class'] ?? null;
        $this->image = $data['image'] ?? null;
        $this->biography = $data['biography'] ?? null;
        $this->pv = (int) ($data['pv'] ?? 0);
        $this->mana = (int) ($data['mana'] ?? 0);
        $this->strength = (int) ($data['strength'] ?? 0);
        $this->initiative = (int) ($data['initiative'] ?? 0);
        $this->armor_item_id = $data['armor_item_id'] ?? null;
        $this->primary_weapon_item_id = $data['primary_weapon_item_id'] ?? null;
        $this->secondary_weapon_item_id = $data['secondary_weapon_item_id'] ?? null;
        $this->shield_item_id = $data['shield_item_id'] ?? null;
        $this->armor_item = $data['armor_item'] ?? null;
        $this->primary_weapon_item = $data['primary_weapon_item'] ?? null;
        $this->secondary_weapon_item = $data['secondary_weapon_item'] ?? null;
        $this->shield_item = $data['shield_item'] ?? null;
        $this->spell_list = $this->decodeSpellList($data['spell_list'] ?? null);
        $this->xp = (int) ($data['xp'] ?? 0);
        $this->current_level = (int) ($data['current_level'] ?? 1);
    }

    private function decodeSpellList($val)
    {
        if (is_array($val)) {
            return $val;
        }
        if ($val === null || $val === '') {
            return [];
        }
        $decoded = json_decode($val, true);
        return is_array($decoded) ? $decoded : [];
    }

    private function encodeSpellList()
    {
        return json_encode($this->spell_list, JSON_UNESCAPED_UNICODE);
    }

    // Getters / Setters (essentiels)
    public function getId() { return $this->id; }
    public function setId($v) { $this->id = $v; }

    public function getName() { return $this->name; }
    public function setName($v) { $this->name = $v; }

    public function getCompteId() { return $this->compte_id; }
    public function setCompteId($v) { $this->compte_id = $v; }

    public function getClassId() { return $this->class_id; }
    public function setClassId($v) { $this->class_id = $v; }

    public function getImage() { return $this->image; }
    public function setImage($v) { $this->image = $v; }

    public function getBiography() { return $this->biography; }
    public function setBiography($v) { $this->biography = $v; }

    public function getPv() { return $this->pv; }
    public function setPv($v) { $this->pv = (int)$v; }

    public function getMana() { return $this->mana; }
    public function setMana($v) { $this->mana = (int)$v; }

    public function getStrength() { return $this->strength; }
    public function setStrength($v) { $this->strength = (int)$v; }

    public function getInitiative() { return $this->initiative; }
    public function setInitiative($v) { $this->initiative = (int)$v; }

    public function getArmorItemId() { return $this->armor_item_id; }
    public function setArmorItemId($v) { $this->armor_item_id = $v; }

    public function getPrimaryWeaponItemId() { return $this->primary_weapon_item_id; }
    public function setPrimaryWeaponItemId($v) { $this->primary_weapon_item_id = $v; }

    public function getSecondaryWeaponItemId() { return $this->secondary_weapon_item_id; }
    public function setSecondaryWeaponItemId($v) { $this->secondary_weapon_item_id = $v; }

    public function getShieldItemId() { return $this->shield_item_id; }
    public function setShieldItemId($v) { $this->shield_item_id = $v; }

    // nouveaux getters/setters pour objets ItemModel
    public function getArmorItem() { return $this->armor_item; }
    public function setArmorItem($item) { $this->armor_item = $item; }

    public function getPrimaryWeaponItem() { return $this->primary_weapon_item; }
    public function setPrimaryWeaponItem($item) { $this->primary_weapon_item = $item; }

    public function getSecondaryWeaponItem() { return $this->secondary_weapon_item; }
    public function setSecondaryWeaponItem($item) { $this->secondary_weapon_item = $item; }

    public function getShieldItem() { return $this->shield_item; }
    public function setShieldItem($item) { $this->shield_item = $item; }

    public function getSpellList() { return $this->spell_list; }
    public function setSpellList($v) { $this->spell_list = $this->decodeSpellList($v); }
    public function addSpell($spell) { $this->spell_list[] = $spell; }
    public function removeSpell($key) { if (isset($this->spell_list[$key])) unset($this->spell_list[$key]); }

    public function getXp() { return $this->xp; }
    public function setXp($v) { $this->xp = (int)$v; }

    public function getCurrentLevel() { return $this->current_level; }
    public function setCurrentLevel($v) { $this->current_level = (int)$v; }

    // Accès à l'objet ClassModel
    public function getClass() { return $this->class; }
    public function setClass($classObj) { $this->class = $classObj; }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'compte_id' => $this->compte_id,
            'class_id' => $this->class_id,
            'image' => $this->image,
            'biography' => $this->biography,
            'pv' => $this->pv,
            'mana' => $this->mana,
            'strength' => $this->strength,
            'initiative' => $this->initiative,
            'armor_item_id' => $this->armor_item_id,
            'primary_weapon_item_id' => $this->primary_weapon_item_id,
            'secondary_weapon_item_id' => $this->secondary_weapon_item_id,
            'shield_item_id' => $this->shield_item_id,
            'spell_list' => $this->encodeSpellList(),
            'xp' => $this->xp,
            'current_level' => $this->current_level
        ];
    }

    public static function fromRow(array $row)
    {
        return new self($row);
    }
}
