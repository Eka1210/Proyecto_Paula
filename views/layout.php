<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Función para verificar acceso a las rutas de administrador
function verificarAccesoAdmin() {
    $uri = $_SERVER['REQUEST_URI'];

    // Verifica si la ruta es de administrador
    $isAdminRoute = strpos($uri, '/admin') === 0;

    // Si es una ruta de administrador, verifica autenticación y permisos
    if ($isAdminRoute) {
        if (!isset($_SESSION['login']) || !isset($_SESSION['admin']) || !$_SESSION['admin']) {
            header('Location: /'); // Redirige al inicio si no tiene acceso
            exit;
        }
    }
}

// Llamar a la función para verificar acceso solo en rutas de administrador
verificarAccesoAdmin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PJ Solutions</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;700;900&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="/build/css/app.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/build/css/app.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>
</head>
<body>
    <header class="header section">
        <a href="/" class="logo">
            <img src="/images/logo.png">
        </a>
        <form class="search-bar">
            <div class="buscador">
                <input type="text" name="search" placeholder="Buscar Producto">
                <button class="search-button" type="submit"></button>
            </div>
        </form>

        <div class="actions">
            <?php if(!isset($_SESSION['login'])) { ?>
                <a class="login" href="/login">Iniciar Sesión</a>
                <?php } else { ?>
                    <a class="login" href="/logout">Cerrar Sesión</a>
                    <a class="login" href="/cuenta">Mi Cuenta</a>
                    <a class="carrito" href="/carrito"> </a>
            <?php } ?>
        </div>
    </header>
    <?php
    {
        $page = $page ??"";
    }
    ?>
    <nav class="navegacion">
        <?php if(isset($_SESSION['admin'])){ ?>
            <a <?php if ($page == 'inicio') { echo 'class="active"'; } ?> href="/admin">
            Inicio</a>
        <?php } else {?>
            <a <?php if ($page == 'inicio') { echo 'class="active"'; } ?> href="/">
            Inicio</a>
        <?php } ?>

        <?php if(isset($_SESSION['admin'])){ ?>
            <a <?php if ($page == 'productos') { echo 'class="active"'; } ?> href="/admin/productos">
            Productos</a>
        <?php } else {?>
            <a <?php if ($page == 'productos') { echo 'class="active"'; } ?> href="/productos">
            Productos</a>
        <?php } ?>

        <?php if(isset($_SESSION['admin'])){ ?>
            <a <?php if ($page == 'categorias') { echo 'class="active"'; } ?> href="/admin/categorias">
            Categorías</a>
        <?php } ?>

        <?php if(isset($_SESSION['admin'])) { ?>
            <a <?php if ($page == 'admin') { echo 'class="active"'; } ?> href="/admin">
            Admin</a>
        <?php } ?>
    </nav>

    <?php echo $contenido; ?>

    <footer class="footer section">
        <div class="container footer-content">
            <p class="copyright">PJ Solutions &copy. Todos los derechos reservados.</p>
        </div>
    </footer>
    
    <script src='/build/js/app.js'></script>
</body>
</html>
