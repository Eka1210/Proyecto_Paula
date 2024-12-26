<?php
namespace Controllers;

use MVC\Router;
use Model\Categorias;


class PagesController {
    public static function index(Router $router){
        $router->render('MainMenu/index', [
            'page' => 'inicio'
        ]);
    }

    public static function categorias(Router $router){
        $productos = Producto::all();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(!isset($_SESSION['userId'])){
                header('Location: /login');
            }
            $cart = Cart::where('userId', $_SESSION['userId']);
            $products = productsxcart::whereAll('cartID', $cart->id);
            $exists = false;
            foreach($products as $product){
                if($product->productID == $_POST['producto']){
                    $product->quantity += 1;
                    $product->price += $product->price;
                    $product->guardar();
                    $exists = true;
                    break;
                }
            }
            if(!$exists){
                $productxcart = new productsxcart([
                    'cartID' => $cart->id,
                    'productID' => $_POST['producto'],
                    'quantity' => 1,
                    'price' => Producto::find($_POST['producto'])->price
                ]);
                $productxcart->guardar();
            }
            header('Location: /categorias');
        }
        $router->render('pages/categorias', [
            'productos' => $productos,
            'page' => 'categorias'
        ]);
    }

}