<?php

namespace Controllers;
use MVC\Router;
use Model\Product;
use Model\Category;
use Model\CategoryXProduct;
use Model\Option;
use Model\ProductDecorator;
use Model\OptionsXProduct;

class ProductController {
    public static function admin(Router $router)
    {
        $router->render('ProductsSpects/gestionProductos');
    }
    
    public static function crear(Router $router){
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
    public static function ver(Router $router){
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
        $alertas = Category::getAlertas();
        $router->render('ProductsSpects/gestionProductos', [
            'alertas' => $alertas,
            'productos' => $productos
        ]);
    }

    public static function editar(Router $router){
        //isAdmin();
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
        foreach($categoriaxP as $categoria){
            if($categoria->productID == $producto->id ){
                $categoriaP = Category::find($categoria->categoryID);
                $categoriasP[] = $categoriaP; 
            }
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
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
            if(empty($alertas)){
                $producto->guardar();
                Product::setAlerta('success', 'Producto Editada');
                header('Location: /admin/productos');
            }
        }
        $router->render('ProductsSpects/editProduct', [
            'alertas' => $alertas,
            'name' => $producto->name,
            'descripcion' => $producto->description,
            'producto'=> $producto,
            'categorias'=>$categorias,
            'categoriasP'=>$categoriasP
        ]);
    }


    public static function eliminar(Router $router){
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
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $_POST['id'];
            $producto = Product::find($id); 
            $valid = true;

            $categorias = Category::all();
            $categoriaxP = CategoryXProduct::all();
            $categoriasP = [];
            foreach($categoriaxP as $categoria){
                if($categoria->productID == $producto->id ){
                    $categoriaP = Category::find($categoria->categoryID);
                    $categoriasP[] = $categoriaP; 
                }
            }
            CategoryXProduct::deleteByProduct($producto->id);
            OptionsXProduct::deleteByProduct2($producto->id);
                
            if($valid){
                $producto->eliminar();
                header('Location: /admin/productos');
            }else{
                header('Location: /admin?error=1');
            }
        }
        $alertas = Category::getAlertas();
        $router->render('ProductsSpects/gestionProductos', [
            'alertas' => $alertas,
            'productos' => $productos
        ]);
    }

    public static function imagenes(Router $router)
    {
        $alertas = [];
        $productos = Product::all();

        foreach ($productos as $producto) {
            $producto->name = $producto->name;
        }
        $alertas = Category::getAlertas();
        $router->render('ProductsSpects/gestionImagenes', [
            'alertas' => $alertas,
            'productos' => $productos
        ]);
    }

    public static function subirImagen() {
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
                        $product->setImage($imagePath);
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

    public static function eliminarImagen(Router $router){
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

    
    public static function personalizar(Router $router) {
        $productId = $_GET['id'] ?? null;

        $producto = Product::find($productId);
        $opciones = Option::all();
        $opcionesXP = OptionsXProduct::all();
        $opcionesProducto = [];
        foreach($opcionesXP as $opcion){
            if($opcion->productID == $producto->id ){
                $opcionP = Option::find($opcion->optionID);
                $opcionesProducto[] = $opcionP; 
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            

            header("Location: /personalizacion/producto?id={$productId}");
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_GET['id'] ?? '';
            $optionData = $_POST['nombre']; 
            $values = $_POST['values'] ?? [];

            // Usamos el ProductDecorator para crear la opción
            ProductDecorator::addOptionToProduct($productId, $optionData, $values);
    
            header("Location: /personalizacion/producto?id={$productId}");
            exit;
        }

        $router->render('ProductsSpects/createOption');
    }

    public static function editarOpcion(Router $router)
    {
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
            header("Location: /personalizacion/producto?id={$productId}");
            exit;
        }

        // Renderizar la vista de edición con los datos de la opción
        $router->render('ProductsSpects/editOption', [
            'option' => $option,
            'values' => $values
        ]);
    }

    public static function personalizarP(Router $router) {
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
    
            // Lógica para procesar las opciones seleccionadas
            // Por ejemplo, añadir al carrito
    
            // Redirigir a la página de resumen
            header("Location: ");
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

        $router->render('/inventario/inventario');
    }
    
}
