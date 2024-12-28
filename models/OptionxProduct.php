<?php 
namespace Model;

class OptionxProduct extends ActiveRecord{
    protected static $tabla = 'optionsxproduct';
    protected static $columnasDB = ['create_time','optionID', 'productID'];

    public $create_time;
    public $optionID;
    public $productID;

    public function __construct($args = []){
        $this->create_time = $args['create_time'] ?? null;
        $this->categoryID = $args['optionID'] ?? null;
        $this->productID = $args['productID'] ?? null;
    }
}