<?php 
namespace Model;

class Option extends ActiveRecord{
    protected static $tabla = 'options';
    protected static $columnasDB = ['id', 'name'];

    public $id;
    public $name;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
    }

    public function validate(){
        if(!$this->name){
            self::setAlerta('error', 'El nombre es obligatorio');
        }           
        return self::$alertas;
    }
}