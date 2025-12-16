<?php

class ItemModel
{
    private $id;
    private $name;
    private $description;
    private $item_type;
    private $category;

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'] ?? '';
        $this->description = $data['description'] ?? null;
        $this->item_type = $data['item_type'] ?? '';
        $this->category = $data['category'] ?? null;
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
            'item_type' => $this->item_type,
            'category' => $this->category,
        ];
    }

    // Getters / Setters
    public function getId() { return $this->id; }
    public function setId($v) { $this->id = $v; }

    public function getName() { return $this->name; }
    public function setName($v) { $this->name = $v; }

    public function getDescription() { return $this->description; }
    public function setDescription($v) { $this->description = $v; }

    public function getItemType() { return $this->item_type; }
    public function setItemType($v) { $this->item_type = $v; }

    public function getCategory() { return $this->category; }
    public function setCategory($v) { $this->category = $v; }
}
