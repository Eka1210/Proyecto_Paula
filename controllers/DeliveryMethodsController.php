<?php

namespace Controllers;
use MVC\Router;
use Model\Usuario;
use Model\DeliveryMethod;


class DeliveryMethodsController {

    public static function verDeliveryMethods(Router $router){
        isAdmin();
        $metodosEntrega = DeliveryMethod::all();
        $methods =[];

        foreach ($metodosEntrega as $metodoEntrega) {
            $metodoEntrega->id = $metodoEntrega->id;
            $metodoEntrega->create_time = $metodoEntrega->create_time;
            $metodoEntrega->name = $metodoEntrega->name;
            $metodoEntrega->description = $metodoEntrega->description;
            $metodoEntrega->cost = $metodoEntrega->cost;
        }

        foreach ($metodosEntrega as $metodo) {
            if ($metodo->active == 1) {
                $methods[] = $metodo;
            }
        }
        $router->render('methods/deliveryMethods', [
            'metodosEntrega' => $methods
        ]);
    }

    public static function addMetodoEntrega(Router $router){
        isAdmin();
        $metodoEntrega = new DeliveryMethod();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $metodoEntrega = new DeliveryMethod($_POST);
            $alertas = $metodoEntrega->validate();
            if(empty($alertas)){
                $metodoEntrega->create_time = date('Y-m-d H:i:s');
                $metodoEntrega->guardar();
                DeliveryMethod::setAlerta('success', 'Metodo de Entrega Creado');
                header('Location: /admin/metodosEntrega');
            }
        }

        $alertas = DeliveryMethod::getAlertas();
        $router->render('methods/deliveryMethods/createDeliveryMethod', [
            'metodoEntrega' => $metodoEntrega,
            'alertas' => $alertas,
        ]);
    }

    public static function editMetodoEntrega(Router $router){
        isAdmin();
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
                header('Location: /admin/metodosEntrega');
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
        isAdmin();
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
            header('Location: /admin/metodosEntrega');
            exit;
        }
        $alertas = DeliveryMethod::getAlertas();
        $router->render('methods/deliveryMethods/removeDeliveryMethod', [
            'alertas' => $alertas,
            'metodosEntrega' => $metodosEntrega
        ]);
    }


    public static function activoD(Router $router)
    {
        isAdmin();
        $alertas = [];
        $metodosEntrega = DeliveryMethod::all();
         $methods =[];

        foreach ($metodosEntrega as $metodoEntrega) {
            $metodoEntrega->id = $metodoEntrega->id;
            $metodoEntrega->create_time = $metodoEntrega->create_time;
            $metodoEntrega->name = $metodoEntrega->name;
            $metodoEntrega->description = $metodoEntrega->description;
            $metodoEntrega->cost = $metodoEntrega->cost;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $metodosEntrega = DeliveryMethod::find($id);
            $activo = $_POST['activo'];
            $metodosEntrega->updateActivo($activo);

            header('Location: /admin/metodosEntrega');
            exit;
        }
        $router->render('methods/deliveryMethods', [
            'metodosEntrega' => $metodosPago
        ]);
    }

    public static function activoD2(Router $router)
    {
        isAdmin();
        $alertas = [];
        $metodosEntrega = DeliveryMethod::all();
        $methods =[];

        foreach ($metodosEntrega as $metodoEntrega) {
            $metodoEntrega->id = $metodoEntrega->id;
            $metodoEntrega->create_time = $metodoEntrega->create_time;
            $metodoEntrega->name = $metodoEntrega->name;
            $metodoEntrega->description = $metodoEntrega->description;
            $metodoEntrega->cost = $metodoEntrega->cost;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $metodoEntrega = DeliveryMethod::find($id);
            $activo = $_POST['activo'];
            $metodoEntrega->updateActivo($activo);

            header('Location: /admin/metodosEntrega/deshabilitados');
            exit;
        }
        $router->render('methods/deliveryMethods/removeDeliveryMethod', [
            'metodoEntrega' => $metodoEntrega
        ]);
    }

    public static function deshabilitadosD(Router $router)
    {
        isAdmin();
        $alertas = [];
        $metodosEntrega = DeliveryMethod::all();
        $methods =[];

        foreach ($metodosEntrega as $metodo) {
            if ($metodo->active == 0) {
                $methods[] = $metodo;
            }
        }
        $router->render('methods/deliveryMethods/removeDeliveryMethod', [
            'metodosEntrega' => $methods
        ]);
    }
}