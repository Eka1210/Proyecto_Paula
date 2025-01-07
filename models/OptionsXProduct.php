<?php 
namespace Model;

class OptionsXProduct extends ActiveRecord {
    protected static $tabla = 'optionsxproduct';
    protected static $columnasDB = ['productID', 'optionID', 'value'];

    public $productID;
    public $optionID;
    public $value;

    public function __construct($args = []) {
        $this->productID = $args['productID'] ?? null;
        $this->optionID = $args['optionID'] ?? null;
        $this->value = $args['value'] ?? '';
    }
}
