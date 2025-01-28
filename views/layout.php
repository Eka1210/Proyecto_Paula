<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Función para verificar acceso a las rutas de administrador
function verificarAccesoAdmin()
{
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" referrerpolicy="no-referrer" />

    
</head>

<body>
    <header class="header section">
        <a href="/" class="logo" style="width: 100px; height: auto;">
            <img src="/images/logo.png">
        </a>
        

        <div class="actions">
            <?php if (!isset($_SESSION['login'])) { ?>
                <a class="login" href="/login">Iniciar Sesión</a>
            <?php } else { ?>
                <a class="login" href="/logout">Cerrar Sesión</a>
                <a class="login" href="/cuenta">Mi Cuenta</a>
                <a class="carrito" href="/cart"> </a>
                <a class="wishlist" href="/wishlist"> </a>
            <?php } ?>
        </div>
    </header>
    <?php {
        $page = $page ?? "";
    }
    ?>
    <nav class="navegacion">
        <?php if (isset($_SESSION['admin'])) { ?>
            <a <?php if ($page == 'admin') {
                    echo 'class="active"';
                } ?> href="/admin/permisos">
                Admin</a>
        <?php } ?>
        <?php if (!isset($_SESSION['admin'])) { ?>
            <a <?php if ($page == 'inicio') {
                    echo 'class="active"';
                } ?> href="/">
                Inicio</a>
        <?php }?>
        <?php if (isset($_SESSION['admin'])) { ?>
            <a <?php if ($page == 'categorias') {
                    echo 'class="active"';
                } ?> href="/admin/categorias">
                Categorías</a>
        <?php } else { ?>
            <a <?php if ($page == 'categorias') {
                    echo 'class="active"';
                } ?> href="/productos">
                Productos</a>
        <?php } ?>

        <?php if (isset($_SESSION['admin'])) { ?>
            <a <?php if ($page == 'productos') {
                    echo 'class="active"';
                } ?> href="/admin/productos">
                Productos</a>
        <?php }?>
        <?php if (isset($_SESSION['admin'])) { ?>
            <a <?php if ($page == 'admin') {
                    echo 'class="active"';
                } ?> href="/admin/inventario">
                Inventario</a>
        <?php } ?>
        
        <?php if (isset($_SESSION['admin'])) { ?>
            <a <?php if ($page == 'admin') {
                    echo 'class="active"';
                } ?> href="/admin/promocion">
                Promociones</a>
        <?php } ?>
        <?php if (isset($_SESSION['admin'])) { ?>
            <a <?php if ($page == 'admin') {
                    echo 'class="active"';
                } ?> href="/admin/reporte">
                Reporte</a>
        <?php } ?>
        
        <?php if (isset($_SESSION['admin'])) { ?>
            <a <?php if ($page == 'admin') {
                    echo 'class="active"';
                } ?> href="/admin/pedidos">
                Pedidos</a>
        <?php } elseif (isset($_SESSION['login'])){ ?>
            <a <?php if ($page == 'Mis pedidos') {
                    echo 'class="active"';
                } ?> href="/pedidos">
                Mis Pedidos</a>
        <?php } ?>
        <?php if (isset($_SESSION['admin'])) { ?>
            <a <?php if ($page == 'admin') {
                    echo 'class="active"';
                } ?> href="/admin/metodosPago">
                Métodos de Pago</a>
        <?php } ?>
        <?php if (isset($_SESSION['admin'])) { ?>
            <a <?php if ($page == 'admin') {
                    echo 'class="active"';
                } ?> href="/admin/metodosEntrega">
                Métodos de Entrega</a>
        <?php } ?>
        <?php if (isset($_SESSION['admin'])) { ?>
            <button id="toggle-nav" class="toggle-nav"></button>
        <?php } ?>
    </nav>

    <?php echo $contenido; ?>

    <footer class="footer section">
    <div class="container footer-content">
        <p class="footer-title">Escríbenos</p>
        <p class="footer-contact">
            <a href="mailto:pj.solutions.notifications@gmail.com">pj.solutions.notifications@gmail.com</a>
        </p>
        <p class="footer-contact">
            WhatsApp: <a href="tel:+50663016703">+506 6301 6703</a>
        </p>
        <p class="footer-location">Cartago, Costa Rica</p>
        <p class="copyright">PJ Solutions &copy; Todos los derechos reservados.</p>
    </div>
</footer>


    <script src='/build/js/app.js'></script>
</body>

<script>
    function checkOverflow() {
    const nav = document.querySelector('.navegacion');
    const toggleNav = document.querySelector('.toggle-nav');
    const links = nav.querySelectorAll('a');

    // Calcular el ancho total de los enlaces visibles
    let totalWidth = 0;
    let hideFromIndex = -1;

    links.forEach((link, index) => {
        totalWidth += link.offsetWidth;

        if (totalWidth > nav.offsetWidth) {
            if (hideFromIndex === -1) hideFromIndex = index;
            link.style.display = 'none'; // Ocultar los que no caben
        } else {
            link.style.display = 'block'; // Mostrar los visibles
        }
    });

    // Mostrar el botón de flecha solo si hay elementos ocultos
    if (hideFromIndex !== -1) {
        toggleNav.style.display = 'block';
    } else {
        toggleNav.style.display = 'none';
    }
}

// Alternar visibilidad de elementos ocultos
document.querySelector('.toggle-nav').addEventListener('click', () => {
    const nav = document.querySelector('.navegacion');
    const links = nav.querySelectorAll('a');
    const toggleNav = document.querySelector('.toggle-nav');

    if (nav.classList.contains('expanded')) {
        // Contraer: Restaurar el estado oculto de los enlaces
        nav.classList.remove('expanded');
        checkOverflow(); // Recalcular cuáles mostrar/ocultar
    } else {
        // Expandir: Mostrar todos los enlaces
        nav.classList.add('expanded');
        links.forEach(link => link.style.display = 'block'); // Mostrar todos
    }
});

// Detectar redimensionamiento de ventana
window.addEventListener('resize', checkOverflow);

// Verificar el estado inicial
checkOverflow();

</script>

</html>
