<?php 
namespace Model;

class Productsxcart extends ActiveRecord{
    protected static $tabla = 'productsxcart';
    protected static $columnasDB = ['cartID', 'productID','quantity', 'price'];

    public $cartID;
    public $productID;
    public $quantity;
    public $price;
    
    public function __construct($args = []) {
        $this->cartID = $args['cartID'] ?? null;
        $this->productID = $args['productID'] ?? null;
        $this->quantity = $args['quantity'] ?? null;
        $this->price = $args['price'] ?? null;
    }
}