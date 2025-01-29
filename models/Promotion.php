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
        } elseif (strlen($this->name) > 45) {
            self::setAlerta('error', 'El nombre no puede exceder los 45 caracteres');
        }
        if ($this->doesNameExist()) {
            self::setAlerta('error', 'La promoción ya existe');
        }
        if (!$this->description) {
            self::setAlerta('error', 'La descripción es obligatoria');
        } elseif (strlen($this->description) > 50) {
            self::setAlerta('error', 'La descripción no puede exceder los 45 caracteres');
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
        if ($this->start_time > $this->end_time) {
            self::setAlerta('error', 'La fecha de inicio no puede ser mayor a la fecha de finalización');
        }

        return self::$alertas;
    }


    public static function getDiscount($productID)
    {
        $today = date('Y-m-d H:i:s');

        $query = "SELECT p.*
                FROM promotions p
                JOIN productxpromotion pxp ON p.id = pxp.promotionID
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
        if (empty(self::$tabla) || empty($this->name)) {
            return false; // Prevent running an invalid query
        }

        $query = "SELECT 1 FROM " . self::$tabla . " WHERE name = ? AND id != ? LIMIT 1";

        $stmt = self::$db->prepare($query);
        if (!$stmt) {
            error_log("MySQL Prepare Error: " . self::$db->error);
            return false; // Log error for debugging
        }

        $stmt->bind_param("si", $this->name, $this->id);
        $stmt->execute();
        $stmt->store_result();

        return $stmt->num_rows > 0;
    }
}
