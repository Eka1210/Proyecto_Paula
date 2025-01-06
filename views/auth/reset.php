<?php 
    include_once __DIR__ . "/../templates/alerts.php";
?>

<?php if(!$error) {?>
<div class="sm-container">
    <h1 class="align-left">Reestablece tu Contraseña</h1>
    <form method="POST" class="form">
        <p class="form__description">Llena el siguiente formulario para reestablecer tu contraseña</p>
        <div class="form__field">
            <label for="password" class="form__label">Contraseña</label>
            <input class="form__input" type="password" placeholder="Tu Contraseña" id="password" name="password">
        </div> <!-- /form__field -->
        <div class="form__field">
            <label for="password2" class="form__label">Confirma Tu Contraseña</label>
            <input class="form__input" type="password" placeholder="Confirma tu Contraseña" id="password2" name="password2">
        </div> <!-- /form__field -->
        <input class="form__submit" type="submit" value="Cambiar">
        <a href="/login" class="action align-center">¿Ya tienes una cuenta? <span>Iniciar Sesión</span></a>
    </form>
</div>

<?php } else{ ?>
    <div class="space"></div>
<?php } ?>