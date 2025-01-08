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

    public static function findProduct($id) {
        $query = "SELECT productID FROM " . static::$tabla  ." WHERE optionID = $id";
        $result = self::$db->query($query);
        $row = $result->fetch_assoc();
        return $row['productID'];
    }

    public static function findValues($id) {
        $query ="SELECT value FROM optionsxproduct WHERE optionID = $id";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }
}
