<?php 
namespace Model;

class Product extends ActiveRecord{
    protected static $tabla = 'products';
    protected static $columnasDB = ['id', 'name', 'description', 'price', 'cantidad', 'imagen', 'encargo', 'activo'];

    public $id;
    public $name;
    public $description;
    public $price;
    public $cantidad;
    public $imagen;
    public $encargo;
    public $quantity;
    public $categories;
    public $activo;
    public $liked;
    public $discount;
    public $discountPercentage;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->description = $args['description'] ?? '';
        $this->price = $args['price'] ?? '';
        $this->cantidad = $args['cantidad'] ?? NULL;
        $this->imagen = $args['imagen'] ?? '';
        $this->encargo = $args['encargo'] ?? 0;
        $this->activo = $args['activo'] ?? 1;
    }

    public function validate(){
        if(!$this->name){
            self::setAlerta('error', 'El nombre es obligatorio');
        }
        if(!$this->description){
            self::setAlerta('error', 'La descripcion es obligatoria');
        }
        if(!$this->price){
            self::setAlerta('error', 'El precio es obligatorio');
        }
        return self::$alertas;
    }

    public function validateCant(){
        if ($this->encargo == 0){
            if(!$this->cantidad){
                self::setAlerta('error', 'La cantidad es obligatoria');
            }
            if($this->cantidad && $this->cantidad <= 0){
                self::setAlerta('error', 'La cantidad debe ser mayor a 0');
            }
        }
        return self::$alertas;
    }

    public function updateImage($imagePath) {
        $query = "UPDATE $tabla SET imagen = '" . self::escapeString($imagePath) . "' WHERE id = " . intval($this->id);
        return self::ejecutarSQL($query);
    }

    private static function escapeString($string) {
        // Escapa caracteres especiales para evitar SQL Injection
        return htmlspecialchars(mysqli_real_escape_string(self::getConnection(), $string));
    }

    public function updateActivo($activo) {
        $query = "UPDATE products SET activo = " . intval($activo) . " WHERE id = " . intval($this->id);
        $resultado = self::$db->query($query);
        return $resultado;
    }

}