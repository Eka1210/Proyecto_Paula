<?php 
namespace Model;

class Cart extends ActiveRecord{
    protected static $tabla = 'cart';
    protected static $columnasDB = ['id', 'userId', 'active', 'promotionID', 'paymentID','deliveryID', 'status', 'deliveryD'];

    public $id;
    public $userId;
    public $active;
    public $promotionID;
    public $paymentID;
    public $deliveryID;
    public $status;
    public $deliveryD;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->userId = $args['userId'] ?? null;
        $this->active = $args['active'] ?? 1; 
        $this->promotionID = $args['promotionID'] ?? null;
        $this->paymentID = $args['paymentID'] ?? null;
        $this->deliveryID = $args['deliveryID'] ?? null;
        $this->status = $args['status'] ?? 'vacio'; 
        $this->deliveryD = $args['deliveryD'] ?? '';

        


    }

}
    


