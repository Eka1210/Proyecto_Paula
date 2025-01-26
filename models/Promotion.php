<?php

namespace Model;

class Promotion extends ActiveRecord
{
    protected static $tabla = 'promotions';
    protected static $columnasDB = ['id', 'description', 'percentage', 'active', 'start_time', 'end_time', 'name'];

    public $id;
    public $description;
    public $percentage;
    public $active;
    public $start_time;
    public $end_time;
    public $name;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->description = $args['description'] ?? '';
        $this->percentage = $args['percentage'] ?? null;
        $this->active = $args['active'] ?? null;
        $this->start_time = $args['start_time'] ?? null;
        $this->end_time = $args['end_time'] ?? null;
        $this->name = $args['name'] ?? '';
    }

    public function validate()
    {
        if (!$this->name) {
            self::setAlerta('error', 'El nombre es obligatorio');
        }
        if (!$this->description) {
            self::setAlerta('error', 'La descripcion es obligatoria');
        }
        if (!$this->percentage) {
            self::setAlerta('error', 'El porcentaje es obligatorio');
        }
        if (!$this->start_time) {
            self::setAlerta('error', 'La fecha de inicio es obligatorio');
        }
        if (!$this->end_time) {
            self::setAlerta('error', 'La fecha de finalización es obligatorio');
        }

        if (!$this->doesNameExist()) {
            self::setAlerta('error', 'La promoción ya existe');
        }
    }


    public static function getDiscount($productID)
    {
        $today = date('Y-m-d H:i:s');

        $query = "SELECT p.*
                FROM promotions p
                JOIN productXpromotion pxp ON p.id = pxp.promotionID
                WHERE pxp.productID = '$productID'
                AND p.active = 1
                AND '$today' BETWEEN p.start_time AND p.end_time
                ORDER BY p.percentage DESC
                LIMIT 1";

        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public function doesNameExist()
    {
        $query = "SELECT * FROM " . self::$tabla . " WHERE TRIM(name) = '" . trim($this->name) . "' AND id <> '" . $this->id . "' LIMIT 1";
        $result = self::$db->query($query);

        if ($result->num_rows) {
            return true;
        }
        return false;
    }
}
