<?php 
namespace Model;

class Promotion extends ActiveRecord{
    protected static $tabla = 'promotions';
    protected static $columnasDB = ['id', 'description', 'percentage', 'active', 'productID'];

    public $id;
    public $description;
    public $percentage;
    public $active;
    public $productID;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->description = $args['description'] ?? '';
        $this->percentage = $args['percentage'] ?? null; 
        $this->active = $args['active'] ?? null; 
        $this->productID = $args['productID'] ?? null;
    }

}