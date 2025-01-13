<?php

namespace Controllers;
use MVC\Router;
use Model\cart;
use Model\Product;
use Model\Productsxcart;
use Model\Usuario;

class CartController {

    public static function ver(Router $router) {
        $router->render('cuenta/cart', []);
    }

    public static function AddToCart(Router $router) {
        // Capturar el ID del producto y precio enviados por POST
        $productoId = $_POST['producto'] ?? null;
        $price = floatval($_POST['price'] ?? 0);

        if ($productoId && $price > 0) {
            // Buscar el producto en la base de datos
            $producto = Product::find($productoId);

            if ($producto && $producto->cantidad > 0) {
                // Obtener el carrito del usuario
                $userId = $_SESSION['userId'];
                $carrito = Cart::where('userId', $userId);

                if ($carrito) {
                    // Verificar si el producto ya está en el carrito
                    $existingItem = Productsxcart::findProductInCar($productoId, $carrito->id);
                    echo '<pre>';
                    print_r($existingItem); // Muestra de forma legible las propiedades del objeto
                    echo '</pre>';
                    if (!is_null($existingItem )) {
                        // Si el producto ya está en el carrito, actualizar cantidad y precio
                        $existingItem->quantity += 1;
                        $existingItem->price = $price * $existingItem->quantity;
                        $resultado = $existingItem->actualizarProductInCart();
                    } else {
                        // Si el producto no está en el carrito, agregar un nuevo registro
                        $cartItem = new Productsxcart([
                            'productID' => $productoId,
                            'quantity' => 1,
                            'cartID' => $carrito->id,
                            'price' => $price,
                        ]);
                        $resultado = $cartItem->guardar();
                    }
                    

                    if ($resultado['resultado']) {
                        echo "<script>alert('¡Producto añadido al carrito exitosamente!');</script>";
                    } else {
                        echo "<script>alert('Hubo un error al añadir el producto al carrito.');</script>";
                    }
                } else {
                    echo "<script>alert('No se encontró un carrito para este usuario.');</script>";
                }
            } else {
                echo "<script>alert('El producto no está disponible.');</script>";
            }
        } else {
            echo "<script>alert('No se pudo procesar tu solicitud.');</script>";
        }

        // Redirigir a la página anterior
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
}