<?php 
namespace Model;

class CategoryXProduct extends ActiveRecord{
    protected static $tabla = 'categoriesxproduct';
    protected static $columnasDB = ['categoryID', 'productID'];

    public $categoryID;
    public $productID;

    public function __construct($args = []){
        $this->categoryID = $args['categoryID'] ?? null;
        $this->productID = $args['productID'] ?? null;
    }
}