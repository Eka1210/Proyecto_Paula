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

}