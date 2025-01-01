<?php 
namespace Model;

class Productxsale extends ActiveRecord{
    protected static $tabla = 'productsxsale';
    protected static $columnasDB = ['salesID','productID', 'quantity', 'price'];

    public $salesID;
    public $productID;
    public $quantity;
    public $price;
    
    public function __construct($args = []) {
        $this->salesID = $args['salesID'] ?? null;
        $this->productID = $args['productID'] ?? null;
        $this->quantity = $args['quantity'] ?? null;
        $this->price = $args['price'] ?? null;
    }

}