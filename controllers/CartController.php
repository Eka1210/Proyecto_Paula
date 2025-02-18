<?php

namespace Controllers;

use MVC\Router;
use Model\Cart;
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
use Model\ProductxPromotion;
use Model\Client;
use Controllers\ProductController;

class CartController
{

    public static function ver(Router $router)
    {
        $alertas = [];
        $userId = $_SESSION['userId'] ?? null;

        if ($userId) {
            $carrito = Cart::where('userId', $userId);
            $productosEnCarrito = [];

            if ($carrito) {
                $productosxCart = Productsxcart::allCart($carrito->id);

                foreach ($productosxCart as $productoEnCarrito) {

                    $producto = Product::find($productoEnCarrito->productID);

                    if ($producto) {
                        $productoEnCarrito->name = $producto->name;
                        $productoEnCarrito->encargo = $producto->encargo;
                        $productoEnCarrito->imagen = $producto->imagen;
                    }else{
                        $productoEncarrito->name = 'Producto Deshabilitado';
                    }

                    // Obtener las categorías del producto
                    $categoryIDs = CategoryxProduct::all2($productoEnCarrito->productID);
                    $categorias = [];
                    foreach ($categoryIDs as $categoryID) {
                        $categoria = Category::find($categoryID->categoryID);
                        if ($categoria) {
                            $categorias[] = $categoria;
                        }
                    }

                    // Almacenamos las categorías en el producto
                    $productoEnCarrito->categories = $categorias;
                    $productosEnCarrito[] = $productoEnCarrito;
                    
                }
            }
            $alertas = Sale::getAlertas();

            $router->render('ventas/cart', [
                'alertas' => $alertas,
                'productos' => $productosEnCarrito,
            ]);
        } else {
            header('Location: /login');
            exit;
        }
    }

    public static function AddToCart(Router $router)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productoId = $_POST['producto'] ?? null;
            $price = floatval($_POST['price'] ?? 0);
            $quantity = intval($_POST['quantity'] ?? 1);
            $values = $_POST['values'] ?? null;
            $userId = $_SESSION['userId'] ?? null;

            if ($userId == null) {
                echo '<script>alert("Debes iniciar sesión para agregar productos al carrito");window.location.href = "/login";</script>';
                exit;
            }

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
            $resultado = self::processAddToCart($productoId, $quantity, $price, $userId,$values);

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
    public static function processAddToCart($productoId, $quantity, $price, $userId,$values)
    {
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
        if ($producto->encargo == 1) {
            $isEncargo = true;
        }
        if (!$producto) {
            return [
                'success' => false,
                'message' => 'El producto no está disponible.',
            ];
        }

        if (!$isEncargo) {
            if ($producto->cantidad <= 0) {
                return [
                    'success' => false,
                    'message' => 'El producto no está disponible.',
                ];
            }
        }

        // Verificar si el producto ya está en el carrito
        if($isEncargo){
            $existingItem = Productsxcart::findProductInCart3($productoId, $carrito->id,$values);
        }else{
            $existingItem = Productsxcart::findProductInCart($productoId, $carrito->id);
        }
        error_log($values);
        if (!is_null($existingItem)) {
            if ($isEncargo) {
                $existingItem->quantity += $quantity;
                $resultado = $existingItem->actualizarCustomProductInCart();

            } elseif ($producto->cantidad >= ($existingItem->quantity + $quantity)) {
                $existingItem->quantity += $quantity;
                $resultado = $existingItem->actualizarProductInCart();
            } else {
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
                'price' => $price,
                'customization' => $values
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

    public static function removeFromCart(Router $router)
    {
        // Verificamos que el usuario esté autenticado
        $userId = $_SESSION['userId'] ?? null;

        if ($userId) {
            // Obtener el productID que se quiere eliminar
            $productId = $_POST['productID'] ?? null;
            $encargos = $_POST['encargo'] ?? null;
            $values = $_POST['values'] ?? null;

            if (!is_null($productId)) {
                // Buscar el carrito del usuario
                $carrito = Cart::where('userId', $userId);

                if (!is_null($carrito)) {
                    // Buscar el producto en el carrito
                    if ($encargos == 1){
                        $productoEnCarrito = Productsxcart::findProductInCart2($productId, $carrito->id, $values );
                    } else{
                        $productoEnCarrito = Productsxcart::findProductInCart($productId, $carrito->id);
                    }
                    if ($productoEnCarrito) {
                        // Eliminar el producto del carrito
                        if ($productoEnCarrito->quantity > 1) {
                            $productoEnCarrito->quantity -= 1;

                            if ($encargos == 0){
                                $productoEnCarrito->actualizarProductInCart();
                            }else{
                                $productoEnCarrito->actualizarCustomProductInCart();
                            }
                        } else {
                            if ($encargos == 0){
                                $productoEnCarrito->deleteFromCart($productId, $carrito->id);
                            }else{
                                $productoEnCarrito->deleteCustomFromCart($productId, $carrito->id,$values);
                            }
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

    private static function obtenerPromocionesDelProducto(int $productID, array $promocionesActivas): ?Promotion
    {
        $promocionMayor = null;
        $promocionesDelProducto = [];

        foreach ($promocionesActivas as $promocion) {
            // Verificar si el producto está asociado con la promoción
            $productoEnPromocion = ProductxPromotion::isProductPromotion($productID, $promocion->id);
            if ($productoEnPromocion) {
                if ($promocion->percentage >= $promocionMayor->percentage) {
                    $promocionMayor = $promocion;
                }
            }
        }

        return $promocionMayor;
    }

    private static function aplicarDescuentoPorPromocion(object $producto, object $promocion): float
    {
        // El descuento es un porcentaje sobre el precio del producto
        $descuentoPorProducto = $producto->price * ($promocion->percentage / 100);
        return $descuentoPorProducto * $producto->quantity; // Descuento total por cantidad
    }

    private static function calcularDescuento(array $productos): array
    {
        $promocionesActivas = Promotion::getActivePromotions();

        foreach ($productos as $producto) {
            $producto->discount = 0;
            $producto->discountPercentage = 0;

            if($producto->productID){
                $promocionesDelProducto = self::obtenerPromocionesDelProducto($producto->productID, $promocionesActivas);
            }elseif($producto->id){
                $promocionesDelProducto = self::obtenerPromocionesDelProducto($producto->id, $promocionesActivas);
            }else{
                return null;
            }
            if ($promocionesDelProducto) {
                $producto->discount += self::aplicarDescuentoPorPromocion($producto, $promocionesDelProducto);
                $producto->discountPercentage += $promocionesDelProducto->percentage; // Último porcentaje aplicado
            }
        }

        return $productos;
    }

    public static function checkout(Router $router)
    {
        $userId = $_SESSION['userId'] ?? null;
        $totalMonto = $_POST['totalMonto'] ?? null;;

        $carrito = Cart::where('userId', $userId);
        $productosEnCarrito = [];

        if ($carrito) {
            $productosxCart = Productsxcart::allCart($carrito->id);

            foreach ($productosxCart as $productoEnCarrito) {
                $producto = Product::find($productoEnCarrito->productID);
                if ($producto){
                    $productoEnCarrito->name = $producto->name;
                }else{
                    $productoEnCarrito->name = 'Producto Deshabilitado';
                }
                $productosEnCarrito[] = $productoEnCarrito;
            }
        }

        $metodsPago = PaymentMethod::all();
        $metodosPago =[];

        foreach ($metodsPago as $metodo){
            if ($metodo->active == 1){
                $metodosPago []= $metodo;
            }
        }

        $metodsEntrega = DeliveryMethod::all();

        $metodosEntrega =[];

        foreach ($metodsEntrega as $metodo){
            if ($metodo->active == 1){
                $metodosEntrega []= $metodo;
            }
        }

        $productosEnCarrito = self::calcularDescuento($productosEnCarrito);
        $router->render('ventas/checkout', [
            'productos' => $productosEnCarrito,
            'totalMonto' => $totalMonto,
            'descuento' => array_sum(array_column($productosEnCarrito, 'discount')), // Suma total de descuentos
            'metodosPago' => $metodosPago,
            'metodosEntrega' => $metodosEntrega
        ]);
    }

    public static function confirmOrder(Router $router)
    {
        $alertas = [];

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

        if (is_null($cliente->name) or $cliente->name == ' ') {
            $alertas = [];
            $alertas = Sale::setAlerta('error', 'Debe actualizar sus datos personales para realizar el pedido');
            $alertas = Sale::getAlertas();
            $userId = $_SESSION['userId'] ?? null;
            $totalMonto = $_POST['totalMonto'] ?? null;

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
                'alertas' => $alertas,
                'productos' => $productosEnCarrito,
                'totalMonto' => $totalMonto,
                'descuento' => array_sum(array_column($productosEnCarrito, 'discount')), // Suma total de descuentos
                'metodosPago' => $metodosPago,
                'metodosEntrega' => $metodosEntrega
            ]);
            exit;
        }

        date_default_timezone_set('America/Costa_Rica');
        $fecha = date('Y-m-d H:i:s');
        $pedido = new Sale([
            'descripcion' => 'Pago pendiente',
            'monto' => $totalMonto,
            'fecha' => $fecha,
            'discount' => $descuento,
            'userId' => $cliente->id,
            'paymentMethodId' => $metodoPago->id,
            'deliveryMethodId' => $metodoEntrega->id,
            'deliveryCost' => $metodoEntrega->cost,
        ]);
        $resultado = $pedido->crearSale();
        $orderId = $resultado['id'];

        // Limpiar el carrito y crear registros en ProductxSale

        $carrito = Cart::where('userId', $userId);

        if ($carrito) {
            $productosxCart = Productsxcart::allCart($carrito->id);
            foreach ($productosxCart as $productoEnCarrito) {
                $productID = $productoEnCarrito->productID;

                $saleItem = new Productxsale([
                    'salesID' => $orderId,
                    'productID' => $productID,
                    'quantity' => $productoEnCarrito->quantity,
                    'price' => $productoEnCarrito->price,
                    'customization' => $productoEnCarrito->customization
                ]);

                $productoReal = Product::find($productID);

                if ($productoReal->encargo == 0) {
                    ProductController::createInventory($productID, $productoEnCarrito->quantity, 'Pedido Realizado', 0);
                }
                $saleItem->guardar();
                $productoEnCarrito->deleteFromCart($productID, $carrito->id);
            }
        }

        // Renderizar la página de éxito
        $router->render('ventas/success', [
            'alertas' => $alertas,
            'orderId' => $orderId,
            'totalAmount' => $totalMonto,
        ]);
    }
}
