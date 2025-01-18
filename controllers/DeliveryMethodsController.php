<?php

namespace Controllers;
use MVC\Router;
use Model\Usuario;
use Model\DeliveryMethod;


class DeliveryMethodsController {

    public static function verDeliveryMethods(Router $router){
        $metodosEntrega = DeliveryMethod::all();

        foreach ($metodosEntrega as $metodoEntrega) {
            $metodoEntrega->id = $metodoEntrega->id;
            $metodoEntrega->create_time = $metodoEntrega->create_time;
            $metodoEntrega->name = $metodoEntrega->name;
            $metodoEntrega->description = $metodoEntrega->description;
            $metodoEntrega->cost = $metodoEntrega->cost;
        }
        $router->render('methods/deliveryMethods', [
            'metodosEntrega' => $metodosEntrega
        ]);
    }

    public static function addMetodoEntrega(Router $router){

        $metodoEntrega = new DeliveryMethod();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $metodoEntrega = new DeliveryMethod($_POST);
            $alertas = $metodoEntrega->validate();
            if(empty($alertas)){
                $metodoEntrega->create_time = date('Y-m-d H:i:s');
                $metodoEntrega->guardar();
                DeliveryMethod::setAlerta('success', 'Metodo de Entrega Creado');
                header('Location: /metodosEntrega');
            }
        }

        $alertas = DeliveryMethod::getAlertas();
        $router->render('methods/deliveryMethods/createDeliveryMethod', [
            'metodoEntrega' => $metodoEntrega,
            'alertas' => $alertas,
        ]);
    }

    public static function editMetodoEntrega(Router $router){
        $alertas = [];
        $metodoEntrega = $_GET['id'] ?? null;
        $metodoEntregaID = DeliveryMethod::find3($metodoEntrega);
        $resultado = $metodoEntregaID->fetch_assoc()['id'];

        $metodoEntrega = DeliveryMethod::find($resultado);

        $nombre = $metodoEntrega->name;
        $descripcion = $metodoEntrega->description;
        $costo = $metodoEntrega->cost;

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $metodoEntrega->sincronizar($_POST);
            $alertas = $metodoEntrega->validate();
            if(empty($alertas)){
                $metodoEntrega->guardar();
                DeliveryMethod::setAlerta('success', 'Método de Entrega editado');
                header('Location: /metodosEntrega');
            }
        }
        $alertas = DeliveryMethod::getAlertas();
        $router->render('methods/deliveryMethods/editDeliveryMethod', [
            'alertas' => $alertas,
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'costo' => $costo
        ]);
    }

    public static function removeMetodoEntrega(Router $router){
        $alertas = [];
        $metodosEntrega = DeliveryMethod::all();

        foreach ($metodosEntrega as $metodoEntrega) {
            $metodoEntrega->name = $metodoEntrega->name;
            $metodoEntrega->id = $metodoEntrega->id;
            $metodoEntrega->description = $metodoEntrega->description;
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $_POST['id'];
            $metodoEntrega = DeliveryMethod::find($id);
            $metodoEntrega->eliminar();
            header('Location: /metodosEntrega');
            exit;
        }
        $alertas = DeliveryMethod::getAlertas();
        $router->render('methods/deliveryMethods/removeDeliveryMethod', [
            'alertas' => $alertas,
            'metodosEntrega' => $metodosEntrega
        ]);
    }
}