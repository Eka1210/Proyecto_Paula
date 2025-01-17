<?php 
namespace Model;

class PaymentMethod extends ActiveRecord{
    protected static $tabla = 'paymentmethods';
    protected static $columnasDB = ['id', 'create_time', 'name', 'description'];

    public $id;
    public $create_time;
    public $name;
    public $description;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->create_time = $args['create_time'] ?? ''; // Fecha y hora actual por defecto
        $this->name = $args['name'] ?? '';
        $this->description = $args['description'] ?? '';
    }

    public function validate(){
        if(!$this->name){
            self::setAlerta('error', 'El nombre es obligatorio');
        }
        if(!$this->description){
            self::setAlerta('error', 'La descripcion es obligatoria');
        }
        return self::$alertas;
    }
}
