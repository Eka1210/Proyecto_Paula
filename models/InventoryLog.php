<?php

namespace Model;

class Inventorylog extends ActiveRecord
{
    protected static $tabla = 'inventorylog';
    protected static $columnasDB = ['id', 'action', 'quantity', 'old_value', 'new_value', 'date', 'productID'];

    public $id;
    public $action;
    public $quantity;
    public $old_value;
    public $new_value;
    public $date;
    public $productID;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->action = $args['action'] ?? '';
        $this->quantity = $args['quantity'] ?? '';
        $this->old_value = $args['old_value'] ?? '';
        $this->new_value = $args['new_value'] ?? null;
        $this->date = $args['date'] ?? '';
        $this->productID = $args['productID'] ?? null;
    }

    public function validate()
    {
        if (!$this->action) {
            self::setAlerta('error', 'El motivo del movimiento es obligatorio');
        }
        if (!$this->quantity) {
            self::setAlerta('error', 'La cantidad es obligatoria');
        }
        if (!$this->productID) {
            self::setAlerta('error', 'El producto es obligatorio');
        }

        return self::$alertas;
    }
}
