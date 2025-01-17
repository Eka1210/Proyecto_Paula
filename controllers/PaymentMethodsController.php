<?php

namespace Controllers;
use MVC\Router;
use Model\Usuario;
use Model\PaymentMethod;
use Model\deliveryMethod;

class PaymentMethodsController {

    public static function verPaymentMethods(Router $router){
        $metodosPago = PaymentMethod::all();

        foreach ($metodosPago as $metodoPago) {
            $metodoPago->id = $metodoPago->id;
            $metodoPago->create_time = $metodoPago->create_time;
            $metodoPago->name = $metodoPago->name;
            $metodoPago->description = $metodoPago->description;
        }
        $router->render('methods/paymentMethods', [
            'metodosPago' => $metodosPago
        ]);
    }

    public static function addMetodoPago(Router $router){

        $metodoPago = new PaymentMethod();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $metodoPago = new PaymentMethod($_POST);
            $alertas = $metodoPago->validate();
            if(empty($alertas)){
                $metodoPago->create_time = date('Y-m-d H:i:s');
                $metodoPago->guardar();
                PaymentMethod::setAlerta('success', 'Metodo de Pago Creado');
                header('Location: /metodosPago');
            }
        }

        $alertas = PaymentMethod::getAlertas();
        $router->render('methods/paymentMethods/createPaymentMethod', [
            'metodoPago' => $metodoPago,
            'alertas' => $alertas,
        ]);
    }

    public static function editMetodoPago(Router $router){
        $alertas = [];
        $metodoPago = $_GET['id'] ?? null;
        $metodoPagoID = PaymentMethod::find3($metodoPago);
        $resultado = $metodoPagoID->fetch_assoc()['id'];

        $metodoPago = PaymentMethod::find($resultado);

        $nombre = $metodoPago->name;
        $descripcion = $metodoPago->description;

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $metodoPago->sincronizar($_POST);
            $alertas = $metodoPago->validate();
            if(empty($alertas)){
                $metodoPago->guardar();
                PaymentMethod::setAlerta('success', 'Método de pago editado');
                header('Location: /metodosPago');
            }
        }
        $alertas = PaymentMethod::getAlertas();
        $router->render('methods/paymentMethods/editPaymentMethod', [
            'alertas' => $alertas,
            'nombre' => $nombre,
            'descripcion' => $descripcion
        ]);
    }

    public static function removeMetodoPago(Router $router){
        $alertas = [];
        $metodosPago = PaymentMethod::all();

        foreach ($metodosPago as $metodoPago) {
            $metodoPago->name = $metodoPago->name;
            $metodoPago->id = $metodoPago->id;
            $metodoPago->description = $metodoPago->description;
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $_POST['id'];
            $metodoPago = PaymentMethod::find($id);
            $metodoPago->eliminar();
            header('Location: /metodosPago');
            exit;
        }
        $alertas = PaymentMethod::getAlertas();
        $router->render('methods/paymentMethods/removePaymentMethod', [
            'alertas' => $alertas,
            'metodosPago' => $metodosPago
        ]);
    }
}