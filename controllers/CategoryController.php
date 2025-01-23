<?php

namespace Controllers;
use MVC\Router;
use Model\Category;
use Model\CategoryXProduct;

class CategoryController {
    public static function index(Router $router){
        isAdmin();
        $result = $_GET['result'] ?? null;
        $error = $_GET['error'] ?? null;

        $categorias = Category::all();

        $router->render('admin/index', [
            'categorias' => $categorias,
            'result' => $result,
            'error' => $error,
            'page' => 'admin'
        ]);
    }

    public static function admin(Router $router)
    {
        /*if (!isAdmin()) {
            header('Location: /');
        }*/
        $router->render('ProductsSpects/gestionCategorias');
    }
    
    public static function crear(Router $router){
        //isAdmin();
        $categoria = new Category();
        $alertas = [];
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $categoria = new Category($_POST);
            $alertas = $categoria->validate();
            if(empty($alertas)){
                $categoria->guardar();
                header('Location: /admin/categorias');
            }
        }
        $router->render('ProductsSpects/createCategory', [
            'categoria' => $categoria,
            'alertas' => $alertas
        ]);
    }

    public static function ver(Router $router){
        $alertas = [];
        $categorias = Category::all();

        foreach ($categorias as $categoria) {
            $categoria->nombre = $categoria->nombre;
            $categoria->id = $categoria->id;
            $categoria->descripcion = $categoria->descripcion;
            $categoria->imagen = $categoria->imagen;
        }
        $alertas = Category::getAlertas();
        $router->render('ProductsSpects/gestionCategorias', [
            'alertas' => $alertas,
            'categorias' => $categorias
        ]);
    }

    public static function editar(Router $router){
        //isAdmin();
        $alertas = [];
        $categoria = $_GET['id'] ?? null;
        $categoriaID = Category::find2($categoria);
        $resultado = $categoriaID->fetch_assoc()['id'];

        $categoria = Category::find($resultado);

        $nombre = $categoria->nombre;
        $descripcion = $categoria->descripcion;
        $categoria->imagen = $categoria->imagen;

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $categoria->sincronizar($_POST);
            $alertas = $categoria->validate();
            if(empty($alertas)){
                $categoria->guardar();
                Category::setAlerta('success', 'Categoría Editada');
                
                header('Location: /admin/categorias');
            }
        }
        $alertas = Category::getAlertas();
        $router->render('ProductsSpects/editCategory', [
            'alertas' => $alertas,
            'nombre' => $nombre,
            'descripcion' => $descripcion
        ]);
    }

    public static function eliminar(Router $router){
        $alertas = [];
        $categorias = Category::all();

        foreach ($categorias as $categoria) {
            $categoria->nombre = $categoria->nombre;
            $categoria->id = $categoria->id;
            $categoria->descripcion = $categoria->descripcion;
            $categoria->imagen = $categoria->imagen;
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $_POST['id'];
            $categoria = Category::find($id); 
            $valid = CategoryXProduct::categoria($id);


            if ($valid === true){
                $categoria->eliminar();
                header('Location: /admin/categorias');
                exit;
            }
            else{
                Category::setAlerta('error', 'Esta Categoria está en uso, no se puede eliminar');

            }
        }
        $alertas = Category::getAlertas();
        $router->render('ProductsSpects/gestionCategorias', [
            'alertas' => $alertas,
            'categorias' => $categorias
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
    
                    $category = Category::find($id);
                    if ($category) {
                        $category->setImage2($imagePath);
                        $category->guardar();
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
                $category = Category::find($id);
                if ($category) {
                    $category->deleteImage2();
                    $category->guardar();
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
}