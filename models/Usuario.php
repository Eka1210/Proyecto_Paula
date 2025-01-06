<?php

namespace Model;

class Usuario extends ActiveRecord{
    protected static $tabla = 'users';
    protected static $columnasDB = ['id', 'create_time', 'username', 'email', 'password', 'admin', 'verified', 'token'];
    
    public $id;
    public $create_time;
    public $username;
    public $email;
    public $password;
    public $admin;
    public $verified;
    public $token;

    public function __construct($args = []){
        $this->id = $args['userId'] ?? null;
        $this->create_time = $args['create_time'] ?? '';
        $this->username = $args['username'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->admin = $args['admin'] ?? 0;
        $this->verified = $args['verified'] ?? 0;
        $this->token = $args['token'] ?? '';
    }

    public function validateRegister(){
        if(!$this->email){
            self::setAlerta('error', 'El email es obligatorio');
        }
        if(!$this->username){
            self::setAlerta('error', 'El nombre de usuario es obligatorio');
        }
        if(!$this->password){
            self::setAlerta('error', 'La contraseña es obligatoria');
        } else if(strlen($this->password) < 6) {
            self::$alertas['error'][] = 'La contraseña debe tener al menos 6 caracteres';
        }

        return self::$alertas;
    }

    public function validateLogin(){
        if(!$this->email){
            self::setAlerta('error', 'El email es obligatorio');
        }else if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            self::setAlerta('error', 'El email es inválido');
        }

        if(!$this->password){
            self::setAlerta('error', 'La contraseña es obligatoria');
        }

        return self::$alertas;
    }

    public function validateUpdate(){
        if(!$this->username){
            self::setAlerta('error', 'El nombre de usuario es obligatorio');
        }

        return self::$alertas;
    }

    public function verificarPassword($password){
        $result = password_verify($password, $this->password);
        
        if(!$result || !$this->verified){
            self::$alertas['error'][] = 'La contraseña es incorrecta o el usuario no está verificado';
        } else {
            return true;
        }
    }

    public function exists(){
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";
        $result = self::$db->query($query);

        if($result->num_rows) {
            self::$alertas['error'][] = 'El email ya está registrado';
        }

        $query = "SELECT * FROM " . self::$tabla . " WHERE username = '" . $this->username . "' LIMIT 1";
        $result = self::$db->query($query);

        if($result->num_rows) {
            self::$alertas['error'][] = 'El nombre de usuario ya está registrado';
        }

        return $result;
    }

    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function generateToken() {
        $this->token = uniqid();
    }

    public function validateEmail(){
        if(!$this->email) {
            self::$alertas['error'][] = 'El correo es obligatorio';
        }else if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'El correo no es válido';
        }
        return self::$alertas;
    }

    public function validatePassword(){
        if(!$this->password) {
            self::$alertas['error'][] = 'La contraseña es olbigatoria';
        }else if(strlen($this->password) < 6) {
            self::$alertas['error'][] = 'La contraseña debe tener al menos 6 caracteres';
        }
        return self::$alertas;
    }

    public function comparePasswords($passwd1, $passwd2){
        if($passwd1 != $passwd2){
            self::setAlerta('error', 'Las contraseñas no son iguales');
        }
        $this->validatePassword();
        return self::$alertas;
    }

}