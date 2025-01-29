<?php 
namespace Model;

class PaymentMethod extends ActiveRecord{
    protected static $tabla = 'paymentmethods';
    protected static $columnasDB = ['id', 'create_time', 'name', 'description', 'active'];

    public $id;
    public $create_time;
    public $name;
    public $description;
    public $active;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->create_time = $args['create_time'] ?? ''; // Fecha y hora actual por defecto
        $this->name = $args['name'] ?? '';
        $this->description = $args['description'] ?? '';
        $this->active = $args['active'] ?? 1;
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

    public function updateActivo($activo)
    {
        $query = "UPDATE paymentmethods SET active = " . intval($activo) . " WHERE id = " . intval($this->id);
        $resultado = self::$db->query($query);
        return $resultado;
    }
}
