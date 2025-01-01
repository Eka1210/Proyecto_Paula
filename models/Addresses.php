<?php 
namespace Model;

class Addresses extends ActiveRecord{
    protected static $tabla = 'directionsxclient';
    protected static $columnasDB = ['provincia','canton','distrito', 'direccion', 'clientID'];

    public $provincia;
    public $canton;
    public $distrito;
    public $direccion;
    public $clientID;

    public function __construct($args = []) {
        $this->provincia = $args['provincia'] ?? '';
        $this->canton = $args['canton'] ?? '';
        $this->distrito = $args['distrito'] ?? '';
        $this->direccion = $args['direccion'] ?? '';
        $this->clientID = $args['clientID'] ?? null;
    }
}