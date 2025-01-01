<?php 
namespace Model;

class PaymentMethod extends ActiveRecord{
    protected static $tabla = 'paymentsMethods';
    protected static $columnasDB = ['id', 'create_time', 'name', 'description'];

    public $id;
    public $create_time;
    public $name;
    public $description;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->create_time = $args['create_time'] ?? ''); // Fecha y hora actual por defecto
        $this->name = $args['name'] ?? '';
        $this->description = $args['description'] ?? '';
    }
}
