<?php

namespace Controllers;
use MVC\Router;
use Model\cart;
use Model\Product;
use Model\Productsxcart;
use Model\Usuario;
use Model\Category;
use Model\CategoryXProduct;

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
            $router->render('cuenta/cart', [
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
            $existingItem->quantity += $quantity;
            $existingItem->price = $price * $existingItem->quantity;
            $resultado = $existingItem->actualizarProductInCart();
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
                    $productoEnCarrito = Productsxcart::findProductInCart($productId, $carrito);
                    
                    if ($productoEnCarrito) {
                        // Eliminar el producto del carrito
                        $resultado = $productoEnCarrito->deleteFromCart($productId, $carrito);
                        if ($resultado) {
                            echo "<script>alert('¡Producto eliminado del carrito!');</script>";
                        } else {
                            echo "<script>alert('Hubo un error al eliminar el producto.');</script>";
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
    
            // Redirigir a la página del carrito
            header('Location: /cart');
            exit;
        } else {
            header('Location: /login');
            exit;
        }
    }
    
}
