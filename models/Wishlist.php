<?php 
namespace Model;

class Wishlist extends ActiveRecord{
    protected static $tabla = 'wishList';
    protected static $columnasDB = ['create_time','userID','productID'];

    public $create_time;
    public $userID;
    public $productID;
    
    public function __construct($args = []){
        $this->create_time = $args['create_time'] ?? '';
        $this->userID = $args['userID'] ?? null;
        $this->productID = $args['productID'] ?? null;
    }


}