<?php

namespace Controllers;
use MVC\Router;
use Model\Usuario;

class AdminController {
    public static function permisos(Router $router){
        isAdmin();
        $result = $_GET['result'] ?? null;
        $error = $_GET['error'] ?? null;
        $flag = false;

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario = $_POST['usuario'] ;
            if(!Usuario::where('username', $usuario) == null){
                Usuario::makeAdmin('username', $usuario);
                Usuario::setAlerta('success', 'Actualizado exitosamente');
            }
            elseif(!Usuario::where('email', $usuario) == null){
                Usuario::makeAdmin('email', $usuario);
                Usuario::setAlerta('success', 'Actualizado exitosamente');
            }
            else{
                Usuario::setAlerta('error', 'El usuario no existe');
            }

        }
        $alertas = Usuario::getAlertas();
        $router->render('permisos/permisos', [
            'error' => $error,
            'page' => 'admin',
            'alertas' =>$alertas,
        ]);
    }

    public static function ver(Router $router){
        $alertas = [];
        $router->render('permisos/permisos', [
            'alertas' =>$alertas
        ]);
    }
}