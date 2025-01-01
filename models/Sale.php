<?php 
namespace Model;

class Sale extends ActiveRecord{
    protected static $tabla = 'sales';
    protected static $columnasDB = ['id', 'description', 'monto', 'fecha', 'discount', 'userId'];

    public $id;
    public $description;
    public $monto
    public $fecha;
    public $discount;
    public $userId;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->description = $args['description'] ?? ''; 
        $this->monto = $args['monto'] ?? null;
        $this->fecha = $args['fecha'] ?? '';
        $this->discount = $args['discount'] ?? null; 
        $this->userId = $args['userId'] ?? null;
    }
}
