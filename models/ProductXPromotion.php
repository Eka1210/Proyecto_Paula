<?php

namespace Model;

class ProductsxPromotion extends ActiveRecord
{
    protected static $tabla = 'productXpromotion';
    protected static $columnasDB = ['id', 'productID', 'promotionID'];

    public $cartID;
    public $productID;
    public $promotionID;

    public function __construct($args = [])
    {
        $this->cartID = $args['cartID'] ?? null;
        $this->productID = $args['productID'] ?? null;
        $this->promotionID = $args['promotionID'] ?? null;
    }
}
