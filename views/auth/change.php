<?php 
    include_once __DIR__ . "/../templates/alerts.php";
?>

<div class="sm-container">
    <h1 class="align-left">Cambio de Contraseña</h1>
    <form method="POST" class="form">
        <p class="form__description">Para cambiar tu contraseña, indica tu correo electrónico en el siguiente formulario y te enviaremos las instrucciones</p>
        <div class="form__field">
            <label for="email" class="form__label">Correo Electrónico</label>
            <input class="form__input" type="email" placeholder="Tu Correo Electrónico" id="email" name="email">
        </div> <!-- /form__field -->
        <input class="form__submit" type="submit" value="Enviar">
    </form>
</div>