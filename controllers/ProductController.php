<?php

namespace Controllers;

use MVC\Router;
use Model\Product;
use Model\Category;
use Model\CategoryXProduct;
use Model\Option;
use Model\ProductDecorator;
use Model\OptionsXProduct;
use Model\Inventorylog;
use Model\Wishlist;
use Model\Promotion;
use Model\Review;
use Model\Client;
use Model\Sale;

use Controllers\CartController;

class ProductController
{
    public static function admin(Router $router)
    {
        isAdmin();
        $router->render('ProductsSpects/gestionProductos');
    }

    public static function crear(Router $router)
    {
        isAdmin();
        $producto = new Product();
        $alertas = [];
        $categorias = Category::all();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_POST['encargo'] == 1) {
                $_POST['cantidad'] = 0;
            }
            $producto = new Product($_POST);
            $alertas = $producto->validate();

            if (empty($alertas)) {
                $producto->activo = 1;

                $datos = $producto->guardar();

                if ($datos) {
                    $categoriasSeleccionadas = $_POST['categories'] ?? [];
                    $productoId = $datos['id'];

                    foreach ($categoriasSeleccionadas as $categoriaId) {
                        $categoriaProducto = new CategoryXProduct([
                            'productID' => $productoId,
                            'categoryID' => $categoriaId
                        ]);
                        $categoriaProducto->guardar();
                    }

                    // Redirigir con mensaje de éxito
                    header('Location: /admin/productos');
                    exit;
                }
            }
        }

        $router->render('ProductsSpects/createProduct', [
            'categorias' => $categorias,
            'alertas' => $alertas,
            'producto' => $producto
        ]);
    }
    public static function ver(Router $router)
    {
        isAdmin();
        $alertas = [];
        $products = Product::all();
        $productos = [];

        foreach ($products as $producto) {
            if ($producto->activo == 1) {
                $productos[] = $producto;
            }
        }
        $alertas = Category::getAlertas();
        $router->render('ProductsSpects/gestionProductos', [
            'alertas' => $alertas,
            'productos' => $productos
        ]);
    }

    public static function deshabilitados(Router $router)
    {
        isAdmin();
        $alertas = [];
        $products = Product::all();
        $productos = [];

        foreach ($products as $producto) {
            if ($producto->activo == 0) {
                $productos[] = $producto;
            }
        }
        $alertas = Category::getAlertas();
        $router->render('ProductsSpects/deshabilitados', [
            'alertas' => $alertas,
            'productos' => $productos
        ]);
    }

    public static function editar(Router $router)
    {
        isAdmin();
        $alertas = [];
        $producto = $_GET['id'] ?? null;
        $productoID = Product::find3($producto);
        $resultado = $productoID->fetch_assoc()['id'];

        $producto = Product::find($resultado);

        $producto->name = $producto->name;
        $producto->id = $producto->id;
        $producto->description = $producto->description;
        $producto->price = $producto->price;
        $producto->cantidad = $producto->cantidad;
        $producto->imagen = $producto->imagen;
        $producto->encargo = $producto->encargo;

        $categorias = Category::all();
        $categoriaxP = CategoryXProduct::all();
        $categoriasP = [];
        foreach ($categoriaxP as $categoria) {
            if ($categoria->productID == $producto->id) {
                $categoriaP = Category::find($categoria->categoryID);
                $categoriasP[] = $categoriaP;
            }
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['categories']) && !empty($_POST['categories'])) {
                CategoryXProduct::deleteByProduct($producto->id);
                $categoriasSeleccionadas = $_POST['categories'];
                foreach ($categoriasSeleccionadas as $categoriaId) {
                    $categoriaProducto = new CategoryXProduct([
                        'productID' => $producto->id,
                        'categoryID' => $categoriaId
                    ]);

                    $categoriaProducto->guardar();
                }
            }
            $cantidadOriginal = $producto->cantidad;
            $cantidad = intval($_POST['cantidad']);
            $producto->sincronizar($_POST);
            $alertasInventorio = [];
            if ($cantidadOriginal < $cantidad) {
                $alertasInventorio = ProductController::createInventoryOnly($producto->id, $cantidad - $cantidadOriginal, 'Modificación de admin', true);
            } else if ($cantidadOriginal > $cantidad) {
                $alertasInventorio = ProductController::createInventoryOnly($producto->id, $cantidadOriginal - $cantidad, 'Modificación de admin', false);
            }
            $alertas = array_merge($alertas, $alertasInventorio);

            $alertas = $producto->validate();
            if (empty($alertas)) {

                $producto->guardar();
                Product::setAlerta('success', 'Producto Editada');

                header('Location: /admin/productos');
            }
        }
        $router->render('ProductsSpects/editProduct', [
            'alertas' => $alertas,
            'name' => $producto->name,
            'descripcion' => $producto->description,
            'producto' => $producto,
            'categorias' => $categorias,
            'categoriasP' => $categoriasP
        ]);
    }

    public static function aar(Router $router)
    {
        isAdmin();
        $alertas = [];
        $producto = $_GET['id'] ?? null;
        $productoID = Product::find3($producto);
        $resultado = $productoID->fetch_assoc()['id'];

        $producto = Product::find($resultado);

        $producto->name = $producto->name;
        $producto->id = $producto->id;
        $producto->description = $producto->description;
        $producto->price = $producto->price;
        $producto->cantidad = $producto->cantidad;
        $producto->imagen = $producto->imagen;
        $producto->encargo = $producto->encargo;

        $categorias = Category::all();
        $categoriaxP = CategoryXProduct::all();
        $categoriasP = [];
        foreach ($categoriaxP as $categoria) {
            if ($categoria->productID == $producto->id) {
                $categoriaP = Category::find($categoria->categoryID);
                $categoriasP[] = $categoriaP;
            }
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['categories']) && !empty($_POST['categories'])) {
                CategoryXProduct::deleteByProduct($producto->id);
                $categoriasSeleccionadas = $_POST['categories'];
                foreach ($categoriasSeleccionadas as $categoriaId) {
                    $categoriaProducto = new CategoryXProduct([
                        'productID' => $producto->id,
                        'categoryID' => $categoriaId
                    ]);

                    $categoriaProducto->guardar();
                }
            }
            $producto->sincronizar($_POST);
            $alertas = $producto->validate();
            if (empty($alertas)) {
                $producto->guardar();
                Product::setAlerta('success', 'Producto Editada');
                header('Location: /admin/productos');
            }
        }
        $router->render('ProductsSpects/editProduct', [
            'alertas' => $alertas,
            'name' => $producto->name,
            'descripcion' => $producto->description,
            'producto' => $producto,
            'categorias' => $categorias,
            'categoriasP' => $categoriasP
        ]);
    }


    public static function activo(Router $router)
    {
        isAdmin();
        $alertas = [];
        $productos = Product::all();

        foreach ($productos as $producto) {
            $producto->name = $producto->name;
            $producto->id = $producto->id;
            $producto->description = $producto->description;
            $producto->price = $producto->price;
            $producto->cantidad = $producto->cantidad;
            $producto->imagen = $producto->imagen;
            $producto->encargo = $producto->encargo;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $producto = Product::find($id);
            $activo = $_POST['activo'];
            $producto->updateActivo($activo);

            header('Location: /admin/productos');
            exit;
        }
        $alertas = Category::getAlertas();
        $router->render('ProductsSpects/gestionProductos', [
            'alertas' => $alertas,
            'productos' => $productos
        ]);
    }

    public static function activo2(Router $router)
    {
        isAdmin();
        $alertas = [];
        $productos = Product::all();

        foreach ($productos as $producto) {
            $producto->name = $producto->name;
            $producto->id = $producto->id;
            $producto->description = $producto->description;
            $producto->price = $producto->price;
            $producto->cantidad = $producto->cantidad;
            $producto->imagen = $producto->imagen;
            $producto->encargo = $producto->encargo;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $producto = Product::find($id);
            $activo = $_POST['activo'];
            $producto->updateActivo($activo);

            header('Location: /admin/productos/deshabilitados');
            exit;
        }
        $alertas = Category::getAlertas();
        $router->render('ProductsSpects/deshabilitados', [
            'alertas' => $alertas,
            'productos' => $productos
        ]);
    }

    public static function imagenes(Router $router)
    {
        isAdmin();
        $alertas = [];
        $products = Product::all();
        $productos =[];
        $categorias = Category::all();
        foreach ($products as $producto) {
            if ($producto->activo == 1) {
                $productos[] = $producto;
            }
        }

        foreach ($productos as $producto) {
            $producto->name = $producto->name;
        }
        foreach ($categorias as $categoria) {
            $categoria->nombre = $categoria->nombre;
        }
        $alertas = Category::getAlertas();
        $router->render('ProductsSpects/gestionImagenes', [
            'alertas' => $alertas,
            'productos' => $productos,
            'categorias' => $categorias
        ]);
    }

    public static function subirImagen()
    {
        $response = ['success' => false, 'message' => ''];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $id = $_POST['id'] ?? null;
                if (!$id) {
                    $response['message'] = 'ID del producto no proporcionado.';
                    echo json_encode($response);
                    exit;
                }

                $fileTmpPath = $_FILES['image']['tmp_name'];
                $fileName = $_FILES['image']['name'];
                $fileType = $_FILES['image']['type'];

                $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!in_array($fileType, $allowedMimeTypes)) {
                    $response['message'] = 'Formato de imagen no válido.';
                    echo json_encode($response);
                    exit;
                }

                $uploadDir = __DIR__ . '/../public/images/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $newFileName = uniqid('img_', true) . '.' . pathinfo($fileName, PATHINFO_EXTENSION);
                $uploadFilePath = $uploadDir . $newFileName;

                if (move_uploaded_file($fileTmpPath, $uploadFilePath)) {
                    $imagePath = '/images/' . $newFileName;

                    $product = Product::find($id);
                    if ($product) {
                        $product->setImage2($imagePath);
                        $product->guardar();
                        $response['success'] = true;
                        $response['message'] = 'Imagen cargada con éxito.';
                    } else {
                        $response['message'] = 'Producto no encontrado.';
                    }
                } else {
                    $response['message'] = 'Error al mover la imagen.';
                }
            } else {
                $response['message'] = 'No se subió ninguna imagen.';
            }
        }

        echo json_encode($response);
        exit;
    }

    public static function eliminarImagen(Router $router)
    {
        $response = ['success' => false, 'message' => ''];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if ($id) {
                $product = Product::find($id);
                if ($product) {
                    $product->deleteImage2();
                    $product->guardar();
                    $response['success'] = true;
                    $response['message'] = 'Imagen eliminada con éxito.';
                } else {
                    $response['message'] = 'Producto no encontrado.';
                }
            } else {
                $response['message'] = 'ID del producto no proporcionado.';
            }
        }

        echo json_encode($response);
        exit;
    }


    public static function personalizar(Router $router)
    {
        isAdmin();
        $productId = $_GET['id'] ?? null;

        $producto = Product::find($productId);
        $opciones = Option::all();
        $opcionesXP = OptionsXProduct::all();
        $opcionesProducto = [];
        foreach ($opcionesXP as $opcion) {
            if ($opcion->productID == $producto->id) {
                $opcionP = Option::find($opcion->optionID);
                $opcionesProducto[] = $opcionP;
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header("Location: /admin/personalizacion/producto?id={$productId}");
            exit;
        }

        $router->render('ProductsSpects/gestionPersonalizacion', [
            'producto' => $producto,
            'opciones' => $opciones,
            'opcionesProducto' => $opcionesProducto
        ]);
    }

    public static function crearOpcion(Router $router)
    {
        isAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_GET['id'] ?? '';
            $optionData = $_POST['nombre'];
            $values = $_POST['values'] ?? [];

            // Usamos el ProductDecorator para crear la opción
            ProductDecorator::addOptionToProduct($productId, $optionData, $values);

            header("Location: /admin/personalizacion/producto?id={$productId}");
            exit;
        }

        $router->render('ProductsSpects/createOption');
    }

    public static function editarOpcion(Router $router)
    {
        isAdmin();
        $optionID = $_GET['id'] ?? null;

        $option = Option::find($optionID);
        $valuesJson = OptionsXProduct::findValues($optionID);

        // Decodificar el JSON para obtener un array
        $values = json_decode($valuesJson->value, true);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            $valuesJson = $_POST['values'] ?? [];

            ProductDecorator::updateOption($optionID, $nombre, $valuesJson);
            $productId = OptionsXProduct::findProduct($optionID);

            // Redirigir después de la edición
            header("Location: /admin/personalizacion/producto?id={$productId}");
            exit;
        }

        // Renderizar la vista de edición con los datos de la opción
        $router->render('ProductsSpects/editOption', [
            'option' => $option,
            'values' => $values
        ]);
    }

    public static function eliminarOpcion(Router $router)
    {
        
        $alertas = [];
        $productos = Product::all();

        $optionID = $_POST['id'] ?? null;

        $option = Option::find($optionID);
        $valuesJson = OptionsXProduct::findValues($optionID);


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = OptionsXProduct::findProduct($optionID);
            $product = Product::find($productId);
            OptionsXProduct::deleteOp($optionID);
            $option->eliminar();
            $option->guardar();
            $product->guardar();


            // Redirigir después de la edición
            header("Location: /admin/personalizacion/producto?id={$productId}");
            exit;
        }
    }

    public static function personalizarP(Router $router)
    {
        $productId = $_GET['id'] ?? null;

        $product = Product::find($productId);
        $options = OptionsXProduct::all2($productId);

        foreach ($options as &$option) {
            $option->decodedValues = json_decode($option->value, true);
            $optionC = Option::find($option->optionID);
            $option->name = $optionC->name;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $selectedOptions = $_POST['options'] ?? [];
            $quantity = $_POST['quantity'] ?? 1;
            $userId = $_SESSION['userId'] ?? null;
            
            if (!$userId) {
                echo "<script>alert('No se encontró un usuario en la sesión.');</script>";
                header('Location: /admin/personalizacion/producto?id=' . $productId);
                exit;
            }

            // Lógica para añadir al carrito
            $resultado = CartController::processAddToCart($productId, $quantity, $product->price, $userId);

            // Redirigir a la página de resumen
            header("Location: /categorias ");
            exit;
        }

        // Renderizar la vista
        $router->render('profile/personalizar', [
            'product' => $product,
            'options' => $options,
            'productId' => $productId
        ]);
    }

    public static function inventario(Router $router)
    {
        isAdmin();
        $alertas = [];
        $productos = Product::all();

        foreach ($productos as $producto) {
            $producto->name = $producto->name;
            $producto->id = $producto->id;
            $producto->description = $producto->description;
            $producto->price = $producto->price;
            $producto->cantidad = $producto->cantidad;
            $producto->imagen = $producto->imagen;
            $producto->encargo = $producto->encargo;
        }
        $router->render('/inventario/inventario', [
            'productos' => $productos
        ]);
    }

    public static function log(Router $router)
    {
        isAdmin();
        $alertas = [];
        $logTotales = Inventorylog::all();
        $logs = [];
        $product = Product::find($_GET['id']);

        foreach ($logTotales as $log) {
            if ($log->productID == $_GET['id']) {
                $log->productID = $log->productID;
                $log->quantity = $log->quantity;
                $log->action = $log->action;
                $log->date = $log->date;
                $log->old_value = $log->old_value;
                $log->new_value = $log->new_value;
                $logs[] = $log;
            }
        }
        $router->render('/inventario/log', [
            'logs' => $logs,
            'product' => $product
        ]);
    }

    public static function crearlog(Router $router)
    {
        isAdmin();
        $inventario = new Inventorylog();
        $alertas = [];
        $productos = Product::all();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if ($_POST['quantity'] != null) {
                $alertas = ProductController::createInventory($_POST['product'], $_POST['quantity'], $_POST['action'], $_POST['isIncrementing']);
                if (empty($alertas)) {
                    header('Location: /admin/inventario');
                    exit;
                }
            } else {
                Product::setAlerta('error', 'Cantidad no válida');
                $alertas = Product::getAlertas();
            }
        }
        $router->render('/inventario/crear', [
            'inventario' => $inventario,
            'alertas' => $alertas,
            'productos' => $productos
        ]);
    }

    public static function createInventoryOnly($productID, $quantity, $action, $isIncrementing)
    {
        $inventario = new Inventorylog([
            'product' => $productID,
            'quantity' => $quantity,
            'action' => $action
        ]);

        $product = Product::find($productID);

        $inventario->productID = $productID;
        $inventario->quantity = $quantity;
        $inventario->action = $action;
        date_default_timezone_set('America/Costa_Rica');
        $inventario->date = date('Y-m-d H:i:s');
        $inventario->old_value = $product->cantidad;

        if ($isIncrementing == 1) {
            $inventario->new_value = $product->cantidad + $quantity;
            $product->cantidad += $quantity;
        } else {
            $inventario->new_value = $product->cantidad - $quantity;
            $product->cantidad -= $quantity;
        }

        $alertas = $inventario->validate();
        if (empty($alertas)) {
            $inventario->guardar();
        }
        return $alertas;
    }



    public static function createInventory($productID, $quantity, $action, $isIncrementing)
    {
        $inventario = new Inventorylog([
            'product' => $productID,
            'quantity' => $quantity,
            'action' => $action
        ]);

        $product = Product::find($productID);

        $inventario->productID = $productID;
        $inventario->quantity = $quantity;
        $inventario->action = $action;
        date_default_timezone_set('America/Costa_Rica');
        $inventario->date = date('Y-m-d H:i:s');
        $inventario->old_value = $product->cantidad;

        if ($isIncrementing == 1) {
            $inventario->new_value = $product->cantidad + $quantity;
            $product->cantidad += $quantity;
        } else {
            $inventario->new_value = $product->cantidad - $quantity;
            $product->cantidad -= $quantity;
        }

        $alertas = $inventario->validate();
        if (empty($alertas)) {
            $inventario->guardar();
            $product->sincronizar($product);
            $product->guardar();
        }
        return $alertas;
    }

    public static function addReview(Router $router) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener datos de la sesión y del formulario
            $userId = $_SESSION['userId'] ?? null;
            $productID = $_POST['productID'] ?? null;
            $alertas = [];
            if (is_null($userId)) {
                    Review::setAlerta('error', 'No se pudo identificar al cliente');
            } else {
                $client = Client::find4($userId);

                if(!$client){
                    Review::setAlerta('error', 'No se pudo identificar al cliente');
                }else{
                    // Verificar si el cliente ha comprado el producto
                    $compraValida = Sale::isClientBuy($client->id, $productID);

                    if (!$compraValida) {
                        Review::setAlerta('error', 'Solo puedes reseñar productos que has comprado.');
                    } else {
                        // Crear y guardar la reseña
                        $review = new Review($_POST);
                        date_default_timezone_set('America/Costa_Rica');
                        $review->create_time = date('Y-m-d H:i:s'); // Fecha actual
                        $alertas = $review->validate();
                        if (empty($alertas)) {
                            $review->guardar();
                            Review::setAlerta('success', 'Reseña publicada correctamente.');
                        }
                    }
                }
            }

            $producto = Product::find($productID);
            $options = OptionsXProduct::all2($productID);
    
            foreach ($options as &$option) {
                $option->decodedValues = json_decode($option->value, true);
                $optionC = Option::find($option->optionID);
                $option->name = $optionC->name;
            }
    
            if (isset($_SESSION['userId'])) {
                $producto->liked = Wishlist::isLiked($producto->id, $_SESSION['userId']);
            } else {
                $producto->liked = false;
            }
    
    
            $producto->name = $producto->name;
            $producto->id = $producto->id;
            $producto->description = $producto->description;
            $producto->price = $producto->price;
            $producto->cantidad = $producto->cantidad;
            $producto->imagen = $producto->imagen;
            $producto->encargo = $producto->encargo;
            $recomendados = $producto->recomended();
    
            foreach ($recomendados as $recomendado) {
                $recomendado->name = $recomendado->name;
                $recomendado->id = $recomendado->id;
                $recomendado->description = $recomendado->description;
                $recomendado->price = $recomendado->price;
                $recomendado->cantidad = $recomendado->cantidad;
                $recomendado->imagen = $recomendado->imagen;
                $recomendado->encargo = $recomendado->encargo;
                $discount = Promotion::getDiscount($recomendado->id)[0] ?? null;
                $recomendado->discountPercentage = $discount ? $discount->percentage : 0;
            }

            $reviews = Review::all2(intval($producto->id));

            $discount = Promotion::getDiscount($producto->id)[0] ?? null;
            $producto->discountPercentage = $discount ? $discount->percentage : 0;
            $alertas = Review::getAlertas();
            $router->render('ProductsSpects/productsSpects', [
                'producto' => $producto,
                'recomendados' => $recomendados,
                'options' => $options,
                'productId' => $resultado,
                'reviews' => $reviews,
                'alertas' => $alertas
            ]);
        }
    }

    public static function mostrarproducto(Router $router)
    {
        
        $alertas = [];
        $producto = $_GET['nombre'] ?? null;
        $productoID = Product::find3($producto);
        $resultado = $productoID->fetch_assoc()['id'];
        $producto = Product::find($resultado);
        $options = OptionsXProduct::all2($resultado);

        foreach ($options as &$option) {
            $option->decodedValues = json_decode($option->value, true);
            $optionC = Option::find($option->optionID);
            $option->name = $optionC->name;
        }

        if (isset($_SESSION['userId'])) {
            $producto->liked = Wishlist::isLiked($producto->id, $_SESSION['userId']);
        } else {
            $producto->liked = false;
        }


        $producto->name = $producto->name;
        $producto->id = $producto->id;
        $producto->description = $producto->description;
        $producto->price = $producto->price;
        $producto->cantidad = $producto->cantidad;
        $producto->imagen = $producto->imagen;
        $producto->encargo = $producto->encargo;
        $recomendados = $producto->recomended();

        foreach ($recomendados as $recomendado) {
            $recomendado->name = $recomendado->name;
            $recomendado->id = $recomendado->id;
            $recomendado->description = $recomendado->description;
            $recomendado->price = $recomendado->price;
            $recomendado->cantidad = $recomendado->cantidad;
            $recomendado->imagen = $recomendado->imagen;
            $recomendado->encargo = $recomendado->encargo;
            $discount = Promotion::getDiscount($recomendado->id)[0] ?? null;
            $recomendado->discountPercentage = $discount ? $discount->percentage : 0;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $selectedOptions = $_POST['options'] ?? [];
            $quantity = $_POST['quantity'] ?? 1;
            $userId = $_SESSION['userId'] ?? null;
            $customization = $_POST['customization'] ?? null;

            if ($userId == null) {
                echo '<script>alert("Debes iniciar sesión para agregar productos al carrito");window.location.href = "login";</script>';
                exit;
            }

            // Lógica para añadir al carrito
            $resultado = CartController::processAddToCart($resultado, $quantity, $producto->price, $userId,$customization);

            // Redirigir a la página de resumen
            header("Location: /categorias ");
            exit;
        }


        $reviews = Review::all2(intval($producto->id));


        $discount = Promotion::getDiscount($producto->id)[0] ?? null;
        $producto->discountPercentage = $discount ? $discount->percentage : 0;
        $router->render('ProductsSpects/productsSpects', [
            'producto' => $producto,
            'recomendados' => $recomendados,
            'options' => $options,
            'productId' => $resultado,
            'reviews' => $reviews
        ]);
    }



    public static function like(Router $router)
    {

        $userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : null;

        if (!$userId) {
            header("Location: /login");
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (!isset($_GET['productLiked'])) {
                header("Location: /productos"); // Redirect to products page
                exit();
            }

            $router->render('/profile/like');
        } else {
            header("Location: /productos");
            exit();
        }
    }
}
