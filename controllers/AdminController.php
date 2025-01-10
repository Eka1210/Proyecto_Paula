<?php

namespace Controllers;
use MVC\Router;

class AdminController {
    public static function permisos(Router $router){
        isAdmin();
        $result = $_GET['result'] ?? null;
        $error = $_GET['error'] ?? null;


        $router->render('admin/permisos', [
            'result' => $result,
            'error' => $error,
            'page' => 'admin'
        ]);
    }

    public static function ver(Router $router){
        
        $router->render('permisos/permisos', [
            
        ]);
    }
}