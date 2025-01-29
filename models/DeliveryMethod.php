<?php

namespace Model;

class DeliveryMethod extends ActiveRecord
{
    protected static $tabla = 'deliverymethods';
    protected static $columnasDB = ['id', 'create_time', 'name', 'description', 'cost'];

    public $id;
    public $create_time;
    public $name;
    public $description;
    public $cost;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->create_time = $args['create_time'] ?? '';
        $this->name = $args['name'] ?? '';
        $this->description = $args['description'] ?? '';
        $this->cost = $args['cost'] ?? null;
    }

    public function validate()
    {
        if (!$this->name) {
            self::setAlerta('error', 'El nombre es obligatorio');
        }
        if (!$this->description) {
            self::setAlerta('error', 'La descripcion es obligatoria');
        }
        if ($this->cost === null || $this->cost === '') {
            self::setAlerta('error', 'El costo es obligatorio');
        }
        return self::$alertas;
    }
}
