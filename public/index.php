<?php 

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\PagesController;
use Controllers\CategoryController;
use Controllers\ProductController;

$router = new Router();

// Rutas Define
$router->get('/', [PagesController::class, 'index']);

// Rutas Categorías
$router->get('/admin/categorias', [CategoryController::class, 'admin']);
$router->post('/admin/categorias', [CategoryController::class, 'admin']);
$router->get('/admin/categorias/crear', [CategoryController::class, 'crear']);
$router->post('/admin/categorias/crear', [CategoryController::class, 'crear']);
$router->get('/admin/categorias/editar', [CategoryController::class, 'ver']);
$router->post('/admin/categorias/editar', [CategoryController::class, 'ver']);
$router->get('/editar/categoria', [CategoryController::class, 'editar']);
$router->post('/editar/categoria', [CategoryController::class, 'editar']);

// Rutas Productos
$router->get('/admin/productos', [ProductController::class, 'admin']);
$router->post('/admin/productos', [ProductController::class, 'admin']);
$router->get('/admin/productos/crear', [ProductController::class, 'crear']);
$router->post('/admin/productos/crear', [ProductController::class, 'crear']);
$router->get('/admin/productos/editar', [ProductController::class, 'ver']);
$router->post('/admin/productos/editar', [ProductController::class, 'ver']);
$router->get('/editar/producto', [ProductController::class, 'editar']);
$router->post('/editar/producto', [ProductController::class, 'editar']);


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();