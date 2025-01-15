<?php

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\PagesController;
use Controllers\CategoryController;
use Controllers\ProductController;
use Controllers\ImageController;
use Controllers\LoginController;
use Controllers\AdminController;
use Controllers\CartController;
use Controllers\PromotionController;
use Controllers\ReportController;
use Controllers\WishListController;

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
$router->get('/admin', [PagesController::class, 'index']);

// Rutas Categorías
$router->get('/admin/categorias', [CategoryController::class, 'ver']);
$router->post('/admin/categorias', [CategoryController::class, 'admin']);
$router->get('/admin/categorias/crear', [CategoryController::class, 'crear']);
$router->post('/admin/categorias/crear', [CategoryController::class, 'crear']);
$router->get('/admin/editar/categoria', [CategoryController::class, 'editar']);
$router->post('/admin/editar/categoria', [CategoryController::class, 'editar']);
$router->get('/admin/categorias/eliminar', [CategoryController::class, 'eliminar']);
$router->post('/admin/categorias/eliminar', [CategoryController::class, 'eliminar']);
$router->get('/categorias', [PagesController::class, 'categorias']);
$router->get('/categoria', [PagesController::class, 'ver']);

// Rutas Productos
$router->get('/admin/productos', [ProductController::class, 'ver']);
$router->post('/admin/productos', [ProductController::class, 'admin']);
$router->get('/admin/productos/crear', [ProductController::class, 'crear']);
$router->post('/admin/productos/crear', [ProductController::class, 'crear']);
$router->get('/admin/editar/producto', [ProductController::class, 'editar']);
$router->post('/admin/editar/producto', [ProductController::class, 'editar']);
$router->get('/admin/productos/eliminar', [ProductController::class, 'eliminar']);
$router->post('/admin/productos/eliminar', [ProductController::class, 'eliminar']);
$router->get('/productos', [PagesController::class, 'productos']);
$router->get('/admin/personalizacion/producto', [ProductController::class, 'personalizar']);
$router->post('/admin/personalizacion/producto', [ProductController::class, 'personalizar']);
$router->get('/admin/opcion/crear', [ProductController::class, 'crearOpcion']);
$router->post('/admin/opcion/crear', [ProductController::class, 'crearOpcion']);
$router->get('/admin/editar/option', [ProductController::class, 'editarOpcion']);
$router->post('/admin/editar/option', [ProductController::class, 'editarOpcion']);
$router->get('/personalizar/producto', [ProductController::class, 'personalizarP']);
$router->post('/personalizar/producto', [ProductController::class, 'personalizarP']);

//Rutas permisos de admin
$router->get('/admin/permisos', [AdminController::class, 'ver']);
$router->post('/admin/permisos', [AdminController::class, 'permisos']);



// Rutas Imágenes
$router->get('/admin/imagenes', [ProductController::class, 'imagenes']);
$router->post('/admin/imagenes', [ProductController::class, 'imagenes']);
$router->post('/admin/imagenes/subir', [ProductController::class, 'subirImagen']);
$router->post('/admin/imagenes/eliminar', [ProductController::class, 'eliminarImagen']);
$router->post('/admin/imagenesC/subir', [CategoryController::class, 'subirImagen']);
$router->post('/admin/imagenesC/eliminar', [CategoryController::class, 'eliminarImagen']);




// Rutas Carrito
$router->get('/cart', [CartController::class, 'ver']);
$router->post('/cart/AddToCart', [CartController::class, 'AddToCart']);
$router->post('/cart/removeFromCart', [CartController::class, 'removeFromCart']);

//Rutas de descuento
$router->get('/admin/promocion', [PromotionController::class, 'ver']);
$router->post('/admin/promocion', [PromotionController::class, 'promotion']);
$router->get('/admin/promocion/crear', [PromotionController::class, 'crear']);
$router->post('/admin/promocion/crear', [PromotionController::class, 'crear']);
$router->get('/admin/promocion/eliminar', [PromotionController::class, 'eliminar']);
$router->post('/admin/promocion/eliminar', [PromotionController::class, 'eliminar']);
$router->get('/admin/editar/promocion', [PromotionController::class, 'editar']);
$router->post('/admin/editar/promocion', [PromotionController::class, 'editar']);
//Reporte de ventas 
$router->get('/admin/reporte', [ReportController::class, 'reporte']);


//Rutas de inventario
$router->get('/admin/inventario', [ProductController::class, 'inventario']);
$router->post('/admin/inventario', [ProductController::class, 'inventario']);

//Rutas de WishList
$router->get('/wishlist', [WishListController::class, 'list']);
$router->post('/wishlist', [WishListController::class, 'list']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
