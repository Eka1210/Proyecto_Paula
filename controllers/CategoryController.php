<?php

namespace Controllers;
use MVC\Router;
use Model\Category;

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
        $alertas = Category::getAlertas();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $categoria = new Category($_POST);
            $alertas = $categoria->validate();
            if(empty($alertas)){
                $categoria->guardar();
                header('Location: /admin?result=1');
            }
        }
        $router->render('ProductsSpects/createCategory', [
            'categoria' => $categoria,
            'alertas' => $alertas,
        ]);
    }

    /*public static function actualizar(Router $router){
        isAdmin();
        $id = validateORredirect('/admin');
        $producto = Producto::find($id);
        $alertas = Producto::getAlertas();
        $categorias = Categorias::all();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $producto->sincronizar($_POST);
            if($_FILES['imagen']['name'] != ""){
                $imageName = md5(uniqid(rand(), true)) .  '.jpg';
                if($_FILES['imagen']){
                    $image = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 600);
                    $producto->setImage($imageName);
                    if(!is_dir(IMAGES_DIR)){
                        mkdir(IMAGES_DIR);
                    }
                    $image->save(IMAGES_DIR . $imageName);
                }
            }
            
            $alertas = $producto->validate();
            $alertas = array_merge($alertas, $producto->validateCant());
            if(empty($alertas)){
                $producto->guardar();
                header('Location: /admin?result=2');
            }
        }

        $router->render('admin/actualizar', [
            'producto' => $producto,
            'alertas' => $alertas,
            'categorias' => $categorias
        ]);
    }

    public static function eliminar(Router $router){
        isAdmin();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //debuguear($_POST['id']);
            $id = $_POST['id'];
            $producto = Producto::find($id); 
            $valid = true;

            $productosCart = productsxcart::all();
            foreach($productosCart as $prod){
                if($prod->productID == $id){
                    $valid = false;
                }
            }

            $productsSale = productsxsale::all();
            foreach($productsSale as $prod){
                if($prod->productID == $id){
                    $valid = false;
                }
            }
            if($valid){
                $producto->eliminar();
                header('Location: /admin?result=3');
            }else{
                header('Location: /admin?error=1');
            }
        }
    }

    public static function asignar(Router $router){
        isAdmin();
        $result = $_GET['result'] ?? null;

        $current = $_SESSION['userId'];
        $usuarios = Usuario::all();
        $router->render('admin/asignar', [
            'usuarios' => $usuarios,
            'current' => $current,
            'result' => $result
        ]);
    }

    public static function asignarAdmin(Router $router){
        isAdmin();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $_POST['id'];
            $usuario = Usuario::find($id); 
            $usuario->sincronizar($_POST);
            $usuario->guardar();
        }
        header('Location: /admin/asignar?result=4');
    }

    public static function reporte(Router $router){
        isAdmin();
        $sales = Sale::all();
        $products = Producto::all();
        $users = Usuario::all();

        $diferencia = Sale::getDifference();

        $data = Sale::getMonthSales();


        $router->render('admin/reporte', [
            'sales' => $sales,
            'products' => $products,
            'users' => $users,
            'diferencia' => $diferencia,
            'data' => $data
        ]);
    }*/
}