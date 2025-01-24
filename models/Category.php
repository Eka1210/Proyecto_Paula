<?php 
namespace Model;

class Category extends ActiveRecord{
    protected static $tabla = 'categories';
    protected static $columnasDB = ['id', 'nombre', 'descripcion', 'imagen'];

    public $id;
    public $nombre;
    public $descripcion;
    public $imagen;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
    }
    
    public function validate(){
        if(!$this->nombre){
            self::setAlerta('error', 'El nombre es obligatorio');
        }elseif (strlen($this->nombre) > 45) {
            self::setAlerta('error', 'El nombre no puede exceder los 45 caracteres');
        }
        if(!$this->descripcion){
            self::setAlerta('error', 'La descripcion es obligatoria');
        }
    
        return self::$alertas;
    }

    public function updateImage($imagePath) {
        $query = "UPDATE $tabla SET imagen = '" . self::escapeString($imagePath) . "' WHERE id = " . intval($this->id);
        return self::ejecutarSQL($query);
    }
}