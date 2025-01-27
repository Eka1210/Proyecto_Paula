<?php 
namespace Model;

class Productxsale extends ActiveRecord{
    protected static $tabla = 'productsxsale';
    protected static $columnasDB = ['salesID','productID', 'quantity', 'price','customization'];

    public $salesID;
    public $productID;
    public $quantity;
    public $price;
    public $customization;

    public function __construct($args = []) {
        $this->salesID = $args['salesID'] ?? null;
        $this->productID = $args['productID'] ?? null;
        $this->quantity = $args['quantity'] ?? null;
        $this->price = $args['price'] ?? null;
        $this->customization = $args['customization'] ?? null;
    }

}