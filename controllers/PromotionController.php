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
        isAdmin();
        $alertas = [];
        $promociones = Promotion::all();

        foreach ($promociones as $promocion) {
            $promocion->percentage = $promocion->percentage;
            $promocion->id = $promocion->id;
            $promocion->description = $promocion->description;
            $promocion->active = $promocion->active;
            $promocion->start_time = $promocion->start_time;
            $promocion->end_time = $promocion->end_time;
            $promocion->name = $promocion->name;
        }
        $router->render('/promocion/promocion', [
            'promociones' => $promociones
        ]);
    }

    public static function crear(Router $router)
    {
        isAdmin();
        $promocion = new Promotion();
        $alertas = [];
        $productos = Product::all();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $promocion = new Promotion($_POST);
            $promocion->active = 1;
            $alertas = $promocion->validate();
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


    public static function editar(Router $router)
    {
        isAdmin();
        $alertas = [];
        $promocion = Promotion::find($_GET['id']);
        $promocion->percentage = $promocion->percentage;
        $promocion->id = $promocion->id;
        $promocion->description = $promocion->description;
        $promocion->active = $promocion->active;
        $promocion->start_time = $promocion->start_time;
        $promocion->end_time = $promocion->end_time;

        $productos = Product::all();


        $productXpromo = ProductxPromotion::all();
        $productsChecked = [];

        foreach ($productXpromo as $product) {
            if ($product->promotionID == $promocion->id) {
                $productsChecked[] = $product->productID;
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            ProductxPromotion::deleteByPromotion($promocion->id);
            $promocion->sincronizar($_POST);
            $alertas = $promocion->validate();

            $prodSeleccionadas = $_POST['listaProductos'] ?? [];
            $promocionId =  $promocion->id;

            foreach ($prodSeleccionadas as $productoId) {
                $prodXPromotion = new ProductxPromotion([
                    'promotionID' => $promocionId,
                    'productID' => $productoId
                ]);
                $prodXPromotion->guardar();
            }

            if (empty($alertas)) {
                $promocion->guardar();
                Promotion::setAlerta('success', 'Promoción Editada');
                header('Location: /admin/promocion');
            }
        }


        $router->render('promocion/editar', [
            'alertas' => $alertas,
            'productos' => $productos,
            'promocion' => $promocion,
            'productsChecked' => $productsChecked
        ]);
    }


    public static function eliminar(Router $router)
    {
        isAdmin();
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $promocion = Promotion::find($id);
            $valid = true;
            ProductxPromotion::deleteByPromotion($promocion->id);
            if ($valid) {
                $promocion->eliminar();
                header('Location: /admin/promocion');
            } else {
                header('Location: /admin?error=1');
            }
        }
        $alertas = Promotion::getAlertas();
        $router->render('promocion/promocion', [
            'alertas' => $alertas,
            'promociones' => $promociones
        ]);
    }
}
