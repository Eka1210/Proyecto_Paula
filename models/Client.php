<?php 
namespace Model;

class client extends ActiveRecord{
    protected static $tabla = 'clients';
    protected static $columnasDB = ['id', 'name', 'surname', 'phone', 'province', 'canton', 'distrito', 'userID'];

    public $id;
    public $name;
    public $surname;
    public $phone;
    public $province;
    public $canton;
    public $distrito;
    public $userID;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->surname = $args['surname'] ?? '';
        $this->phone = $args['phone'] ?? '';
        $this->province = $args['province'] ?? '';
        $this->canton = $args['canton'] ?? '';
        $this->distrito = $args['distrito'] ?? '';
        $this->userID = $args['userID'] ?? null;
    }
}

