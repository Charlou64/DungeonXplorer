<?php

class ClassModel
{
    private $id;
    private $name;
    private $description;
    private $base_pv;
    private $base_mana;
    private $strength;
    private $initiative;
    private $max_items;

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'] ?? '';
        $this->description = $data['description'] ?? null;
        $this->base_pv = isset($data['base_pv']) ? (int)$data['base_pv'] : 0;
        $this->base_mana = isset($data['base_mana']) ? (int)$data['base_mana'] : 0;
        $this->strength = isset($data['strength']) ? (int)$data['strength'] : 0;
        $this->initiative = isset($data['initiative']) ? (int)$data['initiative'] : 0;
        $this->max_items = isset($data['max_items']) ? (int)$data['max_items'] : 0;
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
            'description' => $this->description,
            'base_pv' => $this->base_pv,
            'base_mana' => $this->base_mana,
            'strength' => $this->strength,
            'initiative' => $this->initiative,
            'max_items' => $this->max_items,
        ];
    }

    // Getters / Setters
    public function getId() { return $this->id; }
    public function setId($v) { $this->id = $v; }

    public function getName() { return $this->name; }
    public function setName($v) { $this->name = $v; }

    public function getDescription() { return $this->description; }
    public function setDescription($v) { $this->description = $v; }

    public function getBasePv() { return $this->base_pv; }
    public function setBasePv($v) { $this->base_pv = (int)$v; }

    public function getBaseMana() { return $this->base_mana; }
    public function setBaseMana($v) { $this->base_mana = (int)$v; }

    public function getStrength() { return $this->strength; }
    public function setStrength($v) { $this->strength = (int)$v; }

    public function getInitiative() { return $this->initiative; }
    public function setInitiative($v) { $this->initiative = (int)$v; }

    public function getMaxItems() { return $this->max_items; }
    public function setMaxItems($v) { $this->max_items = (int)$v; }
}
