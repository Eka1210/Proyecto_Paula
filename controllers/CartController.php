<?php

namespace Controllers;
use MVC\Router;
use Model\Cart;
use Model\Product;
use Model\Productsxcart;

class CartController {

    public static function ver(Router $router){
        $router->render('permisos/permisos', [
        ]);
    }

    public static function AddToCart(){
        $producto = Producto::find($id);
        if ($producto->cantidad > 0) {
            //Falta
            $router->render('permisos/permisos', [
            ]);
        }

    }
}