<?php 
namespace Model;

class Sale extends ActiveRecord{
    protected static $tabla = 'sales';
    protected static $columnasDB = ['id', 'description', 'monto', 'fecha', 'discount', 'userId', 'paymentMethodId', 'deliveryMethodId'];

    public $id;
    public $description;
    public $monto;
    public $fecha;
    public $discount;
    public $userId;
    public $paymentMethodId;
    public $deliveryMethodId;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->description = $args['description'] ?? '';
        $this->monto = $args['monto'] ?? null;
        $this->fecha = $args['fecha'] ?? '';
        $this->discount = $args['discount'] ?? null;
        $this->userId = $args['userId'] ?? null;
        $this->paymentMethodId['paymentMethodId'] ?? null;
        $this->deliveryMethodId['deliveryMethodId'] ?? null;
    }
    public function crearSale() {

        $query = "INSERT INTO sales (descripcion, monto, fecha, discount, userId, paymentMethodId, deliveryMethodId) VALUES
        ('$this->description', $this->monto, NOW(), $this->discount, $this->userId, $this->paymentMethodId, $this->deliveryMethodId)";

        // Resultado de la consulta
        $resultado = self::$db->query($query);
        return [
            'resultado' =>  $resultado,
            'id' => self::$db->insert_id
        ];
    }
}
