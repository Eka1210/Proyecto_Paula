<?php

namespace Controllers;
use MVC\Router;
use Model\cart;
use Model\Product;
use Model\Productsxcart;
use Model\Usuario;
use Model\Category;
use Model\CategoryXProduct;
use Model\Sale;
use Model\Productxsale;
use Model\PaymentMethod;
use Model\DeliveryMethod;
use Model\Promotion;
use Model\ProductXPromotion;
use Model\Client;

class CartController {

    public static function ver(Router $router) {
        $userId = $_SESSION['userId'] ?? null;
    
        if ($userId) {
            $carrito = Cart::where('userId', $userId);
            $productosEnCarrito = [];
    
            if ($carrito) {
                $productosxCart = Productsxcart::allCart($carrito->id);
    
                foreach ($productosxCart as $productoEnCarrito) {
                    $producto = Product::find($productoEnCarrito->productID);

                    if ($producto) {
                        $producto->quantity = $productoEnCarrito->quantity;
                        
                        // Obtener las categorías del producto
                        $categoryIDs = CategoryxProduct::all2($producto->id);
                        $categorias = [];
                        foreach ($categoryIDs as $categoryID) {
                            $categoria = Category::find($categoryID->categoryID);
                            if ($categoria) {
                                $categorias[] = $categoria;
                            }
                        }
    
                        // Almacenamos las categorías en el producto
                        $producto->categories = $categorias;
                        $productosEnCarrito[] = $producto;
                    }
                }
            }
            $router->render('ventas/cart', [
                'productos' => $productosEnCarrito,
            ]);
        } else {
            header('Location: /login');
            exit;
        }
    }

    public static function AddToCart(Router $router) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productoId = $_POST['producto'] ?? null;
            $price = floatval($_POST['price'] ?? 0);
            $quantity = intval($_POST['quantity'] ?? 1);
    
            if (!$productoId || $price <= 0 || $quantity <= 0) {
                echo "<script>alert('Datos inválidos para añadir al carrito.');</script>";
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            }
    
            // Obtener el ID de usuario desde la sesión
            $userId = $_SESSION['userId'] ?? null;
            if (!$userId) {
                echo "<script>alert('No se encontró un usuario en la sesión.');</script>";
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            }
    
            // Procesar lógica de agregar al carrito
            $resultado = self::processAddToCart($productoId, $quantity, $price, $userId);
    
            // Mostrar alertas basadas en el resultado
            if ($resultado['success']) {
                echo "<script>alert('¡Producto añadido al carrito exitosamente!');</script>";
            } else {
                echo "<script>alert('{$resultado['message']}');</script>";
            }
    
            // Redirigir a la página anterior
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
    }
    
    /**
     * Procesa la lógica de agregar un producto al carrito
     */
    public static function processAddToCart($productoId, $quantity, $price, $userId) {
        // Obtener el carrito del usuario
        $carrito = Cart::where('userId', $userId);
    
        if (!$carrito) {
            return [
                'success' => false,
                'message' => 'No se encontró un carrito para este usuario.',
            ];
        }
    
        // Verificar si el producto está en la base de datos
        $producto = Product::find($productoId);
        $isEncargo = false;
        if ($producto->encargo == 1){
            $isEncargo = true;
        }
        if (!$producto) {
            return [
                'success' => false,
                'message' => 'El producto no está disponible.',
            ];
        }

        if(!$isEncargo){
            if($producto->cantidad <= 0){
                return [
                    'success' => false,
                    'message' => 'El producto no está disponible.',
                ];
            }
        }
    
        // Verificar si el producto ya está en el carrito
        $existingItem = Productsxcart::findProductInCart($productoId, $carrito->id);
        if (!is_null($existingItem)) {
            // Actualizar cantidad y precio si ya existe
            if ($isEncargo){
                $existingItem->quantity += $quantity;
                $existingItem->price = $price * $existingItem->quantity;
                $resultado = $existingItem->actualizarProductInCart();
            }elseif ($producto->cantidad >= ($existingItem->quantity + $quantity)){
                $existingItem->quantity += $quantity;
                $existingItem->price = $price * $existingItem->quantity;
                $resultado = $existingItem->actualizarProductInCart();
            }else{
                return [
                    'success' => false,
                    'message' => 'Cantidad no disponible',
                ];
            }

        } else {
            // Agregar un nuevo registro si no existe
            $cartItem = new Productsxcart([
                'productID' => $productoId,
                'quantity' => $quantity,
                'cartID' => $carrito->id,
                'price' => $price * $quantity,
            ]);
            $resultado = $cartItem->guardar();
        }
    
        if ($resultado['resultado']) {
            return [
                'success' => true,
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Hubo un error al procesar el producto en el carrito.',
            ];
        }
    }

    public static function removeFromCart(Router $router) {
        // Verificamos que el usuario esté autenticado
        $userId = $_SESSION['userId'] ?? null;
    
        if ($userId) {
            // Obtener el productID que se quiere eliminar
            $productId = $_POST['productID'] ?? null;
    
            if (!is_null($productId)) {
                // Buscar el carrito del usuario
                $carrito = Cart::where('userId', $userId);

                if (!is_null($carrito)) {
                    // Buscar el producto en el carrito
                    $productoEnCarrito = Productsxcart::findProductInCart($productId, $carrito->id);
                    
                    if ($productoEnCarrito) {
                        // Eliminar el producto del carrito
                        if($productoEnCarrito->quantity > 1){
                            $productoEnCarrito->quantity -= 1;
                            $productoEnCarrito->price = $price * $productoEnCarrito->quantity;
                            $productoEnCarrito->actualizarProductInCart();
                        }else{
                            $productoEnCarrito->deleteFromCart($productId, $carrito->id);
                        }
                    } else {
                        echo "<script>alert('El producto no está en el carrito.');</script>";
                    }
                } else {
                    echo "<script>alert('No se encontró el carrito del usuario.');</script>";
                }
            } else {
                echo "<script>alert('No se especificó el producto a eliminar.');</script>";
            }
            header('Location: /cart');
            exit;
        } else {
            header('Location: /login');
            exit;
        }
    }
    
    private static function obtenerPromocionesDelProducto(int $productID, array $promocionesActivas): Promotion {
        $promocionMayor = 0;
        $promocionesDelProducto = [];

        foreach ($promocionesActivas as $promocion) {
            // Verificar si el producto está asociado con la promoción
            $productoEnPromocion = ProductXPromotion::isProductPromotion($productID,$promocion->id);
            if ($productoEnPromocion) {
                if ($promocion->percentage >= $promocionMayor->percentage){
                    $promocionMayor = $promocion;
                }
            }
        }

        return $promocionMayor;
    }

    private static function aplicarDescuentoPorPromocion(object $producto, object $promocion): float {
        // El descuento es un porcentaje sobre el precio del producto
        $descuentoPorProducto = $producto->price * ($promocion->percentage / 100);
        return $descuentoPorProducto * $producto->quantity; // Descuento total por cantidad
    }

    private static function calcularDescuento(array $productos): array {
        $promocionesActivas = Promotion::getActivePromotions();

        foreach ($productos as $producto) {
            $producto->discount = 0;
            $producto->discountPercentage = 0;

            $promocionesDelProducto = self::obtenerPromocionesDelProducto($producto->id, $promocionesActivas);

            $producto->discount += self::aplicarDescuentoPorPromocion($producto, $promocionesDelProducto);
            $producto->discountPercentage += $promocionesDelProducto->percentage; // Último porcentaje aplicado

        }

        return $productos;
    }

    public static function checkout(Router $router) {
        $userId = $_SESSION['userId'] ?? null;
        $totalMonto = $_POST['totalMonto'] ?? null;;

        $carrito = Cart::where('userId', $userId);
        $productosEnCarrito = [];

        if ($carrito) {
            $productosxCart = Productsxcart::allCart($carrito->id);

            foreach ($productosxCart as $productoEnCarrito) {
                $producto = Product::find($productoEnCarrito->productID);

                if ($producto) {
                    $producto->quantity = $productoEnCarrito->quantity;
                    $productosEnCarrito[] = $producto;
                }
            }
        }

        $metodosPago = PaymentMethod::all();
        $metodosEntrega = DeliveryMethod::all();

        $productosEnCarrito = self::calcularDescuento($productosEnCarrito);

        $router->render('ventas/checkout', [
            'productos' => $productosEnCarrito,
            'totalMonto' => $totalMonto,
            'descuento' => array_sum(array_column($productosEnCarrito, 'discount')), // Suma total de descuentos
            'metodosPago' => $metodosPago,
            'metodosEntrega' => $metodosEntrega
        ]);
    }

    public static function confirmOrder(Router $router) {

        $userId = $_SESSION['userId'] ?? null;
        $totalMonto = $_POST['totalMonto'] ?? null;
        $descuento = $_POST['descuento'] ?? null;
        $metodoPagoId = $_POST['paymentMethod'] ?? null;
        $metodoEntregaId = $_POST['deliveryMethod'] ?? null;


        $metodoPago = PaymentMethod::find($metodoPagoId);
  
        $metodoEntrega = DeliveryMethod::find($metodoEntregaId);
    
        // Sumar el costo del método de entrega al total
        $totalMonto += $metodoEntrega->cost;

        $cliente = Client::find4($userId);

        if(is_null($cliente->name)){
            echo "<script>alert('Debe actualizar sus datos para realizar el pedido.');</script>";
            header('Location: /cart');
            exit;
        }
        $fecha = date('Y-m-d H:i:s');
        $pedido = new Sale([
            'descripcion' => 'Pedido',
            'monto' => $totalMonto,
            'fecha' => $fecha,
            'discount' => $descuento,
            'userId' => $cliente->id,
            'paymentMethodId' => $metodoPago->id,
            'deliveryMethodId' => $metodoEntrega->id,
        ]);
        $resultado = $pedido->crearSale();
        $orderId = $resultado['id'];
        // Renderizar la página de éxito
        $router->render('ventas/success', [
            'orderId' => $orderId,
            'totalAmount' => $totalMonto,
        ]);
    }
}
