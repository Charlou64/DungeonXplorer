<?php
class Inventory
{
    private $id;
    private $hero_id;
    private $item_id; 
    private $quantity;

    public function __construct($id, $hero_id, $item_id, $quantity)
    {
        $this->id = $id;
        $this->hero_id = $hero_id;
        $this->item_id = $item_id;
        $this->quantity = $quantity;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getHero_id()
    {
        return $this->hero_id;
    }

    public function getItem_id()
    {
        return $this->item_id;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }
}