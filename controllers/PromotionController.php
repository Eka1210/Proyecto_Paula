<?php

namespace Controllers;

use MVC\Router;
use Model\Product;
use Model\Promotion;

class PromotionController
{

    public static function promotion(Router $router)
    {

        $router->render('/promocion/promocion');
    }

    public static function ver(Router $router)
    {
        $alertas = [];
        $promociones = Promotion::all();

        foreach ($promociones as $promocion) {
            $promocion->percentage = $promocion->percentage;
            $promocion->id = $promocion->id;
            $promocion->descripcion = $promocion->descripcion;
            $promocion->active = $promocion->active;
            $promocion->productID = Product::find($promocion->productID)->name;
        }




        $router->render('/promocion/promocion', [
            'promociones' => $promociones
        ]);
    }

    public static function crear(Router $router)
    {

        $router->render('/promocion/crear');
    }
}
