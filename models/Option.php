<?php 
namespace Model;

class Option extends ActiveRecord{
    protected static $tabla = 'options';
    protected static $columnasDB = ['id', 'create_time', 'name'];

    public $id;
    public $create_time;
    public $name;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->create_time = $args['nombre'] ?? '';
        $this->name = $args['descripcion'] ?? '';
    }

    public function validate(){
        if(!$this->name){
            self::setAlerta('error', 'El nombre es obligatorio');
        }           
        return self::$alertas;
    }
}