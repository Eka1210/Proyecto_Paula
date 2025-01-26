<?php

namespace Model;

use Model\Product;


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
        if (empty($this->action)) {
            self::setAlerta('error', 'El motivo del movimiento es obligatorio');
        }

        if (!empty($this->action) && strlen($this->action) > 45) {
            self::setAlerta('error', 'El motivo del movimiento no puede superar los 45 caracteres');
        }

        if ($this->quantity == null) {
            self::setAlerta('error', 'La cantidad es obligatoria');
        }

        if (empty($this->productID)) {
            self::setAlerta('error', 'El producto es obligatorio');
        }


        if (!is_numeric($this->new_value) || intval($this->new_value) < 0 || intval($this->new_value) > 2147483647) {
            self::setAlerta('error', 'El nuevo valor debe ser un número entero positivo y dentro del rango permitido');
        }

        if (!is_numeric($this->old_value) || intval($this->old_value) <= 0 || intval($this->old_value) > 2147483647) {
            self::setAlerta('error', 'El valor antiguo debe ser un número entero positivo y dentro del rango permitido');
        }

        if (!Product::doesProductExist($this->productID)) {
            self::setAlerta('error', 'El producto no existe');
        }

        if (!isset($this->action) || !is_string($this->action)) {
            self::setAlerta('error', 'El motivo del movimiento debe ser una cadena de texto válida');
        }

        if (!isset($this->productID) || !is_numeric($this->productID)) {
            self::setAlerta('error', 'El ID del producto debe ser un número válido');
        }

        return self::$alertas;
    }
}
