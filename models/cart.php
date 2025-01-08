<?php 
namespace Model;

class Cart extends ActiveRecord{
    protected static $tabla = 'cart';
    protected static $columnasDB = ['id', 'userId', 'active', 'paymentID','deliveryID', 'status', 'deliveryD'];

    public $id;
    public $userId;
    public $active;
    public $paymentID;
    public $deliveryID;
    public $status;
    public $deliveryD;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->userId = $args['userId'] ?? null;
        $this->active = $args['active'] ?? 1; 
        $this->paymentID = isset($args['paymentID']) ? (int)$args['paymentID'] : null;
        $this->deliveryID = isset($args['deliveryID']) ? (int)$args['deliveryID'] : null;
        $this->status = $args['status'] ?? 'vacio'; 
        $this->deliveryD = $args['deliveryD'] ?? '';
    }
    
    public function crearC() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();
        $paymentID = $this->paymentID !== null ? (int)$this->paymentID : 'NULL';
        $deliveryID = $this->deliveryID !== null ? (int)$this->deliveryID : 'NULL';

        $query = "INSERT INTO cart (userId, active, paymentID, deliveryID, status, deliveryD) VALUES ($this->userId, $this->active, $paymentID, $deliveryID, '$this->status', '$this->deliveryD')";

        // Resultado de la consulta
        $resultado = self::$db->query($query);
        return [
           'resultado' =>  $resultado,
           'id' => self::$db->insert_id
        ];
    }

}





