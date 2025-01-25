<?php

namespace Model;

class Review extends ActiveRecord
{
    protected static $tabla = 'review';
    protected static $columnasDB = ['id', 'create_time', 'review', 'productID', 'rating'];

    public $id;
    public $create_time;
    public $review;
    public $productID;
    public $rating;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->create_time = $args['create_time'] ?? '';
        $this->review = $args['review'] ?? '';
        $this->productID = $args['productID'] ?? null;
        $this->rating = $args['rating'] ?? null;
    }
    public function validate() {
        if (!$this->review) {
            self::setAlerta('error', 'El comentario no puede estar vacío.');
        }
        if (!$this->rating) {
            self::setAlerta('error', 'La calificación es obligatoria.');
        }
        if (!$this->productID) {
            self::setAlerta('error', 'El producto no es válido.');
        }
        return self::$alertas;
    }
}
