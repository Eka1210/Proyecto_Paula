<?php 
namespace Model;

class Sale extends ActiveRecord{
    protected static $tabla = 'sales';
    protected static $columnasDB = ['id', 'descripcion', 'monto', 'fecha', 'discount', 'userId', 'paymentMethodId', 'deliveryMethodId'];

    public $id;
    public $descripcion;
    public $monto;
    public $fecha;
    public $discount;
    public $userId;
    public $paymentMethodId;
    public $deliveryMethodId;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->descripcion = $args['descripcion'] ?? '';
        $this->monto = $args['monto'] ?? null;
        $this->fecha = $args['fecha'] ?? '';
        $this->discount = $args['discount'] ?? null;
        $this->userId = $args['userId'] ?? null;
        $this->paymentMethodId = $args['paymentMethodId'] ?? null;
        $this->deliveryMethodId = $args['deliveryMethodId'] ?? null;
    }
    public function crearSale() {
        $fechaActual = date('Y-m-d H:i:s');
        $query = "INSERT INTO sales (descripcion, monto, fecha, discount, userId, paymentMethodId, deliveryMethodId) VALUES
        ('$this->descripcion', $this->monto, '$this->fecha', $this->discount, $this->userId, $this->paymentMethodId, $this->deliveryMethodId)";

        // Resultado de la consulta
        $resultado = self::$db->query($query);
        return [
            'resultado' =>  $resultado,
            'id' => self::$db->insert_id
        ];
    }

    public function removeUser(){
        $query = "UPDATE " . static::$tabla . " SET userId = null WHERE id = " . $this->id;
        $result = self::$db->query($query);
        return $result;
    }
}
