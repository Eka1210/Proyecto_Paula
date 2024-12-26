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
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $categoria = new Category($_POST);
            $alertas = $categoria->validate();
            if(empty($alertas)){
                $categoria->guardar();
                Category::setAlerta('success', 'Categoría Creada');
                header('Location: /admin/categorias');
            }
        }
        $alertas = Category::getAlertas();
        $router->render('ProductsSpects/createCategory', [
            'categoria' => $categoria,
            'alertas' => $alertas,
        ]);
    }

    public static function ver(Router $router){
        $alertas = [];
        $categorias = Category::all();

        foreach ($categorias as $categoria) {
            $categoria->nombre = $categoria->nombre;
            $categoria->id = $categoria->id;
            $categoria->descripcion = $categoria->descripcion;
        }
        $alertas = Category::getAlertas();
        $router->render('ProductsSpects/viewCategory', [
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

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $categoria->sincronizar($_POST);
            $alertas = $categoria->validate();
            if(empty($alertas)){
                $categoria->guardar();
                Category::setAlerta('success', 'Categoría Editada');
                
                header('Location: /admin/categorias/editar');
            }
        }
        $alertas = Category::getAlertas();
        $router->render('ProductsSpects/editCategory', [
            'alertas' => $alertas,
            'nombre' => $nombre,
            'descripcion' => $descripcion
        ]);
    }
}