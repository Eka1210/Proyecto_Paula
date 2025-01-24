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
use Controllers\PaymentMethodsController;
use Controllers\DeliveryMethodsController;
use Controllers\PedidosController;

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
$router->get('/admin', [PagesController::class, 'index'], true);

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
$router->get('/admin/productos/activo', [ProductController::class, 'activo']);
$router->post('/admin/productos/activo', [ProductController::class, 'activo']);
$router->get('/admin/productos/activo2', [ProductController::class, 'activo2']);
$router->post('/admin/productos/activo2', [ProductController::class, 'activo2']);
$router->get('/productos', [PagesController::class, 'productos']);
$router->get('/admin/personalizacion/producto', [ProductController::class, 'personalizar']);
$router->post('/admin/personalizacion/producto', [ProductController::class, 'personalizar']);
$router->get('/admin/opcion/crear', [ProductController::class, 'crearOpcion']);
$router->post('/admin/opcion/crear', [ProductController::class, 'crearOpcion']);
$router->get('/admin/editar/option', [ProductController::class, 'editarOpcion']);
$router->post('/admin/editar/option', [ProductController::class, 'editarOpcion']);
$router->get('/personalizar/producto', [ProductController::class, 'personalizarP']);
$router->post('/personalizar/producto', [ProductController::class, 'personalizarP']);
$router->get('/admin/eliminar/option', [ProductController::class, 'eliminarOpcion']);
$router->post('/admin/eliminar/option', [ProductController::class, 'eliminarOpcion']);
$router->get('/mostrarproducto', [ProductController::class, 'mostrarproducto']);
$router->post('/mostrarproducto', [ProductController::class, 'mostrarproducto']);
$router->get('/admin/productos/deshabilitados', [ProductController::class, 'deshabilitados']);


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
$router->get('/cart/checkout', [CartController::class, 'checkout']);
$router->post('/cart/checkout', [CartController::class, 'checkout']);
$router->get('/cart/confirmOrder', [CartController::class, 'confirmOrder']);
$router->post('/cart/confirmOrder', [CartController::class, 'confirmOrder']);

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
$router->post('/admin/reporte', [ReportController::class, 'reporte']);


//Rutas de inventario
$router->get('/admin/inventario', [ProductController::class, 'inventario']);
$router->post('/admin/inventario', [ProductController::class, 'inventario']);
$router->get('/admin/inventario/log', [ProductController::class, 'log']);
$router->post('/admin/inventario/log', [ProductController::class, 'log']);
$router->get('/admin/inventario/crear', [ProductController::class, 'crearlog']);
$router->post('/admin/inventario/crear', [ProductController::class, 'crearlog']);

//Rutas de pedidos Admin
$router->get('/admin/pedidos', [PedidosController::class, 'verAdmin']);
$router->post('/pedidosAdmin/guardarEstado', [PedidosController::class, 'editPedido']);
$router->post('/pedidos/verProductosPedido', [PedidosController::class, 'verProductosPedido']);
$router->get('/pedidos/verProductosPedido', [PedidosController::class, 'verProductosPedido']);
$router->get('/pedidos', [PedidosController::class, 'verCliente']);

//Rutas de WishList
$router->get('/wishlist', [WishListController::class, 'list']);
$router->post('/wishlist', [WishListController::class, 'list']);
$router->get('/like', [ProductController::class, 'like']);
$router->post('/like', [ProductController::class, 'like']);
$router->post('/wishlist/eliminar', [WishListController::class, 'eliminar']);
//Rutas de Métodos de Pago
$router->get('/admin/metodosPago', [PaymentMethodsController::class, 'verPaymentMethods']);
$router->post('/admin/addMetodoPago', [PaymentMethodsController::class, 'addMetodoPago']);
$router->get('/admin/addMetodoPago', [PaymentMethodsController::class, 'addMetodoPago']);
$router->post('/admin/editMetodoPago', [PaymentMethodsController::class, 'editMetodoPago']);
$router->get('/admin/editMetodoPago', [PaymentMethodsController::class, 'editMetodoPago']);
$router->post('/admin/removeMetodoPago', [PaymentMethodsController::class, 'removeMetodoPago']);
$router->get('/admin/removeMetodoPago', [PaymentMethodsController::class, 'removeMetodoPago']);

// Rutas de Métodos de Entrega
$router->get('/admin/metodosEntrega', [DeliveryMethodsController::class, 'verDeliveryMethods']);
$router->post('/admin/addMetodoEntrega', [DeliveryMethodsController::class, 'addMetodoEntrega']);
$router->get('/admin/addMetodoEntrega', [DeliveryMethodsController::class, 'addMetodoEntrega']);
$router->post('/admin/editMetodoEntrega', [DeliveryMethodsController::class, 'editMetodoEntrega']);
$router->get('/admin/editMetodoEntrega', [DeliveryMethodsController::class, 'editMetodoEntrega']);
$router->post('/admin/removeMetodoEntrega', [DeliveryMethodsController::class, 'removeMetodoEntrega']);
$router->get('/admin/removeMetodoEntrega', [DeliveryMethodsController::class, 'removeMetodoEntrega']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
