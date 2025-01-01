<?php 
namespace Model;

class Category extends ActiveRecord{
    protected static $tabla = 'categories';
    protected static $columnasDB = ['id', 'nombre', 'descripcion'];

    public $id;
    public $nombre;
    public $descripcion;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
    }
    
    public function validate(){
        if(!$this->nombre){
            self::setAlerta('error', 'El nombre es obligatorio');
        }
        if(!$this->descripcion){
            self::setAlerta('error', 'La descripcion es obligatoria');
        }
    
        return self::$alertas;
    }
}