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
            $accion = $_POST['accion'];
            if(!Usuario::where('username', $usuario) == null){
                if ($accion === 'otorgar') {
                    Usuario::makeAdmin('username', $usuario);
                } elseif ($accion === 'revocar') {
                    Usuario::unmakeAdmin('username', $usuario);
                }
                Usuario::setAlerta('success', 'Actualizado exitosamente');
            }
            elseif(!Usuario::where('email', $usuario) == null){
                if ($accion === 'otorgar') {
                    Usuario::makeAdmin('email', $usuario);
                } elseif ($accion === 'revocar') {
                    Usuario::unmakeAdmin('email', $usuario);
                }
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
    
    public static function revocarPermisos(Router $router){
        isAdmin();
        $result = $_GET['result'] ?? null;
        $error = $_GET['error'] ?? null;


        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            error_log("entra");
            $usuario = $_POST['usuario'] ;
            if(!Usuario::where('username', $usuario) == null){
                
                Usuario::unmakeAdmin('username', $usuario);
                Usuario::setAlerta('success', 'Actualizado exitosamente');
            }
            elseif(!Usuario::where('email', $usuario) == null){
                Usuario::unmakeAdmin('email', $usuario);
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
        isAdmin();
        $alertas = [];
        $router->render('permisos/permisos', [
            'alertas' =>$alertas
        ]);
    }
}