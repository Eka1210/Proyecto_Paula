<?php

namespace Controllers;
use MVC\Router;
use Model\Product;
use Model\Category;
use Model\CategoryXProduct;

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
            $producto->promotion = $producto->promotion;
        }
        $alertas = Category::getAlertas();
        $router->render('ProductsSpects/viewProduct', [
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
        $producto->promotion = $producto->promotion;

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

            error_log('Alertas en editar: ' . json_encode($alertas));
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
                header('Location: /admin/productos/editar');
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
}
