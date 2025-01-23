<?php

namespace Controllers;
use MVC\Router;
use Model\Usuario;
use Model\Sale;
use Model\Productxsale;
use Model\Product;
use Model\Client;
use Model\PaymentMethod;
use Model\DeliveryMethod;
use Model\Category;
use Model\CategoryXProduct;

class PedidosController{
    // Funcion para que el admin vea todos los pedidos
    public static function verAdmin(Router $router){
        $pedidos = Sale::all();

        foreach ($pedidos as $pedido) {
            $pedido->id = $pedido->id;
            $pedido->$descripcion = $pedido->$descripcion;
            $pedido->$monto = $pedido->$monto;
            $pedido->$fecha = $pedido->$fecha;
            $pedido->$discount = $pedido->$discount;
            $pedido->cliente = Client::find($pedido->userId)->name . ' ' . Client::find($pedido->userId)->surname ?? 'Desconocido'; // Nombre del cliente
            $pedido->metodoPago = PaymentMethod::find($pedido->paymentMethodId)->name ?? 'Desconocido'; // Nombre del método de pago
            $pedido->metodoEntrega = DeliveryMethod::find($pedido->deliveryMethodId)->name ?? 'Desconocido'; // Nombre del método de entrega
        }

        $router->render('pedidos/pedidosAdmin', [
            'pedidos' => $pedidos
        ]);
    }

    public static function verProductosPedido(Router $router)
    {
        $pedidoId = $_GET['id'] ?? null;
    
        if ($pedidoId) {
            // Buscar el pedido por ID
            $pedido = Sale::find($pedidoId);
    
            if ($pedido) {
                // Obtener los productos relacionados a la venta
                $productos = Productxsale::allSale($pedidoId);
    
                if ($productos) {
                    // Iterar sobre los productos para obtener información adicional
                    foreach ($productos as $producto) {
                        // Obtener los detalles del producto
                        $productoDetalle = Product::find($producto->productID);
    
                        if ($productoDetalle) {
                            // Agregar nombre, precio y descripción del producto
                            $producto->productName = $productoDetalle->name;
                            $producto->unitPrice = $productoDetalle->price;
                            $producto->description = $productoDetalle->description;
                        } else {
                            $producto->productName = 'Producto no encontrado';
                            $producto->unitPrice = 0.00;
                            $producto->description = 'Sin descripción';
                            $producto->categoryName = 'Sin categoría';
                        }
                    }
                } else {
                    $productos = []; // No hay productos asociados
                }
            } else {
                $productos = []; // No hay pedido encontrado
            }
        } else {
            header('Location: /pedidosAdmin/ver'); // Redirigir si no hay ID
            exit;
        }
    
        // Renderizar la vista con los productos
        $router->render('pedidos/productos', [
            'productos' => $productos,
            'pedidoId' => $pedidoId
        ]);
    }

    public static function editPedido(Router $router){
        $id = $_POST['id'] ?? null;
        $descripcion = $_POST['descripcion'] ?? null;
    
        if ($id && $descripcion) {

            $pedido = Sale::find($id);
            if ($pedido) {
                $pedido->descripcion = $descripcion;
                $pedido->guardar();
            }
        }
        header('Location: /pedidosAdmin');
        exit;
    }

}