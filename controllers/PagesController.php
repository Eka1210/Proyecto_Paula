<?php
namespace Controllers;

use MVC\Router;
use Model\Product;


class PagesController {
    public static function index(Router $router){
        $productos = Product::get(3);
        $router->render('MainMenu/index', [
            'productos' => $productos,
            'page' => 'inicio'
        ]);
    }

    public static function admin(Router $router){
        $router->render('MainMenu/index', [
            'page' => 'inicio'
        ]);
    }


    public static function productos(Router $router){
        $productos = Product::all();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //Para agregar a carrito!!!!!!!!!!!!
        }
        $router->render('profile/productos', [
            'productos' => $productos,
            'page' => 'productos'
        ]);
    }

}