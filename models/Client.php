<?php 
namespace Model;

class client extends ActiveRecord{
    protected static $tabla = 'clients';
    protected static $columnasDB = ['id', 'name', 'surname', 'birthday', 'phone', 'zipCode', 'address', 'marketing','userID'];

    public $id;
    public $name;
    public $surname;
    public $birthday;
    public $phone;
    public $zipCode;
    public $address;
    public $marketing;
    public $userID;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->surname = $args['surname'] ?? '';
        $this->birthday = $args['birthday'] ?? '';
        $this->phone = $args['phone'] ?? '';
        $this->zipCode = $args['zipCode'] ?? '';
        $this->address = $args['address'] ?? '';
        $this->marketing = $args['marketing'] ?? '';
        $this->userID = $args['userID'] ?? null;
    }

    public function validate(){
        // Validar nombre
        if(!$this->name || strlen($this->name) > 50){
            self::setAlerta('error', 'El nombre es obligatorio y debe tener máximo 50 caracteres');
            error_log('error nombre');
        }
    
        // Validar apellidos
        if(!$this->surname || strlen($this->surname) > 50){
            self::setAlerta('error', 'Los apellidos son obligatorios y deben tener máximo 50 caracteres');
            error_log('error apellido');
        }
    
        // Validar fecha de nacimiento
        if(!$this->birthday || !preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $this->birthday)){
            self::setAlerta('error', 'La fecha de nacimiento es obligatoria y debe tener el formato DD/MM/YYYY');
            error_log('error fecha');
        }
    
        // Validar número de teléfono
        if(!$this->phone || !preg_match('/^\\d{4} \d{4}$/', $this->phone)){
            self::setAlerta('error', 'El número de teléfono es obligatorio y debe tener el formato #### ####');
            error_log('error telefono');
        }
    
        // Validar código postal
        if(!$this->zipCode || !preg_match('/^\d{5}$/', $this->zipCode)){
            self::setAlerta('error', 'El código postal es obligatorio y debe ser un número de 5 dígitos');
            error_log('error cp');
        }
    
        // Validar dirección exacta
        if(!$this->address || strlen($this->address) > 150){
            self::setAlerta('error', 'La dirección es obligatoria y debe tener máximo 150 caracteres');
            error_log('error dir');
        }
    
        return self::$alertas;
    }
    
}

