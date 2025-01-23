<?php

namespace Controllers;

use MVC\Router;
use Model\Product;
use Model\Category;
use Model\CategoryXProduct;
use Model\Promotion;
use Model\Wishlist;



class PagesController
{
    public static function index(Router $router)
    {
        $productos = Product::get(3);
        foreach ($productos as $producto) {
            $discount = Promotion::getDiscount($producto->id)[0] ?? null;
            $producto->discountPercentage = $discount ? $discount->percentage : 0;
        }
        $router->render('MainMenu/index', [
            'productos' => $productos,
            'page' => 'inicio'
        ]);
    }

    public static function admin(Router $router)
    {
        $router->render('MainMenu/index', [
            'page' => 'inicio'
        ]);
    }


    public static function productos(Router $router)
    {
        $productos = Product::all();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Para agregar a carrito!!!!!!!!!!!!
        }

        foreach ($productos as $producto) {
            if (isset($_SESSION['userId'])) {
                $producto->liked = Wishlist::isLiked($producto->id, $_SESSION['userId']);
            } else {
                $producto->liked = false;
            }

            $discount = Promotion::getDiscount($producto->id)[0] ?? null;
            $producto->discountPercentage = $discount ? $discount->percentage : 0;
        }



        $router->render('profile/productos', [
            'productos' => $productos,
            'page' => 'productos'
        ]);
    }

    public static function categorias(Router $router)
    {
        $categorias = Category::all();
        $productos = Product::all();
        foreach ($productos as $producto) {
            $discount = Promotion::getDiscount($producto->id)[0] ?? null;
            $producto->discountPercentage = $discount ? $discount->percentage : 0;
        }
        $router->render('profile/categorias', [
            'categorias' => $categorias,
            'productos' => $productos,
            'page' => 'categorias'
        ]);
    }

    public static function ver(Router $router)
    {
        $categoryID = $_GET['id'] ?? null;
        $categoria = Category::find($categoryID);
        $productosC = CategoryXProduct::findProducts($categoryID);
        $productos = [];

        foreach ($productosC as $producto) {
            $productos[] = Product::find($producto->productID);
        }

        $router->render('profile/categoria', [
            'categoria' => $categoria,
            'productos' => $productos,
            'page' => 'categoria'
        ]);
    }
}
