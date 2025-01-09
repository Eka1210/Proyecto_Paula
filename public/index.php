<?php 

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\PagesController;
use Controllers\CategoryController;
use Controllers\ProductController;
use Controllers\ImageController;
use Controllers\LoginController;

$router = new Router();

// Rutas Auth
$router->get('/login', [LoginController::class, 'index']);
$router->post('/login', [LoginController::class, 'index']);
$router->get('/logout', [LoginController::class, 'logout']);
$router->get('/mensaje', [LoginController::class, 'mensaje']);
$router->get('/verificar', [LoginController::class, 'verificar']);
$router->get('/register', [LoginController::class, 'register']);
$router->post('/register', [LoginController::class, 'register']);
$router->get('/forgot', [LoginController::class, 'forgot']);
$router->post('/forgot', [LoginController::class, 'forgot']);
$router->get('/change', [LoginController::class, 'changePassword']);
$router->post('/change', [LoginController::class, 'changePassword']);
$router->get('/reset', [LoginController::class, 'reset']);
$router->post('/reset', [LoginController::class, 'reset']);
$router->get('/cuenta', [LoginController::class, 'cuenta']);
$router->get('/cuenta/actualizar', [LoginController::class, 'actualizarCuenta']);
$router->post('/cuenta/actualizar', [LoginController::class, 'actualizarCuenta']);
$router->get('/cuenta/eliminar', [LoginController::class, 'eliminarCuenta']);

// Rutas Define
$router->get('/', [PagesController::class, 'index']);

// Rutas Categorías
$router->get('/admin/categorias', [CategoryController::class, 'ver']);
$router->post('/admin/categorias', [CategoryController::class, 'admin']);
$router->get('/admin/categorias/crear', [CategoryController::class, 'crear']);
$router->post('/admin/categorias/crear', [CategoryController::class, 'crear']);
$router->get('/editar/categoria', [CategoryController::class, 'editar']);
$router->post('/editar/categoria', [CategoryController::class, 'editar']);
$router->get('/admin/categorias/eliminar', [CategoryController::class, 'eliminar']);
$router->post('/admin/categorias/eliminar', [CategoryController::class, 'eliminar']);

// Rutas Productos
$router->get('/admin/productos', [ProductController::class, 'ver']);
$router->post('/admin/productos', [ProductController::class, 'admin']);
$router->get('/admin/productos/crear', [ProductController::class, 'crear']);
$router->post('/admin/productos/crear', [ProductController::class, 'crear']);
$router->get('/editar/producto', [ProductController::class, 'editar']);
$router->post('/editar/producto', [ProductController::class, 'editar']);
$router->get('/admin/productos/eliminar', [ProductController::class, 'eliminar']);
$router->post('/admin/productos/eliminar', [ProductController::class, 'eliminar']);
$router->get('/productos', [PagesController::class, 'productos']);
$router->get('/personalizacion/producto', [ProductController::class, 'personalizar']);
$router->post('/personalizacion/producto', [ProductController::class, 'personalizar']);
$router->get('/admin/opcion/crear', [ProductController::class, 'crearOpcion']);
$router->post('/admin/opcion/crear', [ProductController::class, 'crearOpcion']);
$router->get('/admin/editar/option', [ProductController::class, 'editarOpcion']);
$router->post('/admin/editar/option', [ProductController::class, 'editarOpcion']);





// Rutas Imágenes
$router->get('/admin/imagenes', [ProductController::class, 'imagenes']);
$router->post('/admin/imagenes', [ProductController::class, 'imagenes']);
$router->post('/admin/imagenes/subir', [ProductController::class, 'subirImagen']);
$router->post('/admin/imagenes/eliminar', [ProductController::class, 'eliminarImagen']);


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();