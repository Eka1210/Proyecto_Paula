<?php 
    include_once __DIR__ . "/../templates/alerts.php";
?>

<div class="sm-container">
    <h1 class="align-left">Registrar Cuenta</h1>
    <form method="POST" class="form">
        <div class="form__field">
            <label for="name" class="form__label">Nombre</label>
            <input class="form__input" type="text" placeholder="Tu Nombre" id="name" name="name" value="<?php echo s($user->name) ?>">
        </div> <!-- /form__field -->
        <div class="form__field">
            <label for="surname" class="form__label">Apellido</label>
            <input class="form__input" type="text" placeholder="Tu Apellido" id="surname" name="surname" value="<?php echo s($user->surname) ?>">
        </div> <!-- /form__field -->
        <div class="form__field">
            <label for="phone" class="form__label">Teléfono</label>
            <input class="form__input" type="tel" placeholder="Tu Número Telefónico" id="phone" name="phone" value="<?php echo s($user->phone) ?>">
        </div> <!-- /form__field -->
        <div class="form__field">
            <label for="email" class="form__label">Correo Electrónico</label>
            <input class="form__input" type="email" placeholder="Tu Correo Electrónico" id="email" name="email" value="<?php echo s($user->email) ?>">
        </div> <!-- /form__field -->
        <div class="form__field">
            <label for="username" class="form__label">Nombre de Usuario</label>
            <input class="form__input" type="text" placeholder="Tu Nombre de Usuario" id="username" name="username" value="<?php echo s($user->username) ?>">
        </div> <!-- /form__field -->
        <div class="form__field">
            <label for="password" class="form__label">Contraseña</label>
            <input class="form__input" type="password" placeholder="Tu Contraseña" id="password" name="password" >
        </div> <!-- /form__field -->
        <input class="form__submit" type="submit" value="Ingresar">
        <a href="/login" class="action align-center">¿Ya tienes una cuenta? <span>Inicia Sesión</span></a>
    </form>
</div>