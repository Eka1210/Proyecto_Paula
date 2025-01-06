<?php 
    include_once __DIR__ . "/../templates/alerts.php";
?>

<div class="sm-container">
    <h1 class="align-left">Iniciar Sesión</h1>
    <form method="POST" class="form">
        <div class="form__field">
            <label for="email" class="form__label">Correo Electrónico</label>
            <input class="form__input" type="email" placeholder="Tu Correo Electrónico" id="email" name="email">
        </div> <!-- /form__field -->
        <div class="form__field">
            <label for="password" class="form__label">Contraseña</label>
            <input class="form__input" type="password" placeholder="Tu Contraseña" id="password" name="password">
        </div> <!-- /form__field -->
        <a href="/forgot" class="action align-right">¿Olvidaste tu Contraseña?</a>
        <input class="form__submit" type="submit" value="Ingresar">
        <a href="/register" class="action align-center">¿Aún no tienes un usuario? <span>Registrate Aquí</span></a>
    </form>
</div>