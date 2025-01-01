<?php 
namespace Model;

class Cart extends ActiveRecord{
    protected static $tabla = 'cart';
    protected static $columnasDB = ['id', 'userId', 'active', 'promotionID', 'deliveryID', 'status', 'deliveryD'];

    public $id;
    public $userId;
    public $active;
    public $promotionID;
    public $deliveryID;
    public $status;
    public $deliveryD;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->userId = $args['userId'] ?? null;
        $this->active = $args['active'] ?? null; 
        $this->promotionID = $args['promotionID'] ?? null;
        $this->deliveryID = $args['deliveryID'] ?? null;
        $this->status = $args['status'] ?? 'Pendiente'; // estado inicial pendiente
        $this->deliveryD = $args['deliveryD'] ?? '';
    }

}
    


