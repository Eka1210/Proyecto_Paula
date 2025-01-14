<?php

namespace Controllers;

use MVC\Router;
use Model\Product;
use Model\Promotion;
use Model\ProductxPromotion;


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
            $promocion->description = $promocion->description;
            $promocion->active = $promocion->active;
            $promocion->start_time = $promocion->start_time;
            $promocion->end_time = $promocion->end_time;
        }




        $router->render('/promocion/promocion', [
            'promociones' => $promociones
        ]);
    }

    public static function crear(Router $router)
    {
        $promocion = new Promotion();
        $alertas = [];
        $productos = Product::all();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $promocion = new Promotion($_POST);
            $alertas = $promocion->validate();
            $promocion->active = 1;
            if (empty($alertas)) {
                $datos = $promocion->guardar();

                if ($datos) {
                    $prodSeleccionadas = $_POST['listaProductos'] ?? [];
                    $promocionId = $datos['id'];

                    foreach ($prodSeleccionadas as $productoId) {
                        $prodXPromotion = new ProductxPromotion([
                            'promotionID' => $promocionId,
                            'productID' => $productoId
                        ]);
                        $prodXPromotion->guardar();
                    }

                    // Redirigir con mensaje de éxito
                    header('Location: /admin/promocion');
                    exit;
                }
            }
        }

        $router->render('/promocion/crear', [
            'promocion' => $promocion,
            'alertas' => $alertas,
            'productos' => $productos
        ]);
    }
}
