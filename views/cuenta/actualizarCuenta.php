<?php 
    include_once __DIR__ . "/../templates/alerts.php";

    //Encontrar usuario actual
    use Model\Usuario;
    $id = $_SESSION['userId'];
    $userActual = Usuario::find($id);
?>

<div class="consultar-cuenta">
    <a class="orange-btn" href="/cuenta">Volver al Panel</a>
    <form method="POST" class="consultar-cuenta__form">
        <h1>Actualizar tu Cuenta</h1>
        <div class="form__field">
            <label for="name" class="form__label">Nombre</label>
            <input class="form__input" type="text" placeholder="Tu Nombre" id="name" name="name" value="<?php echo $client->name; ?>">
        </div> <!-- /form__field -->

        <div class="form__field">
            <label for="surname" class="form__label">Apellido</label>
            <input class="form__input" type="text" placeholder="Tu Apellido" id="surname" name="surname" value="<?php echo $client->surname; ?>">
        </div> <!-- /form__field -->

        <?php if ($userActual->username !== 'master') { ?>
            <div class="form__field">
                <label for="username" class="form__label">Nombre de Usuario</label>
                <input class="form__input" type="text" placeholder="Tu nombre de usuario" id="username" name="username" value="<?php echo $user->username; ?>">
            </div> <!-- /form__field -->
        <?php } ?>

        <div class="form__field">
            <label for="phone" class="form__label">Teléfono</label>
            <input class="form__input" type="tel" placeholder="Tu Teléfono" id="phone" name="phone" value="<?php echo $client->phone; ?>">
        </div> <!-- /form__field -->

        <div class="form__field">
            <label for="email" class="form__label">Correo Electrónico</label>
            <input class="form__input" type="email" placeholder="Tu correo electrónico" id="email" name="email" value="<?php echo $user->email; ?>">
        </div> <!-- /form__field -->

        <div class="form__field">
            <label for="birthday" class="form__label">Fecha de Nacimiento</label>
            <input class="form__input" type="text" placeholder="DD/MM/YYYY" id="birthday" name="birthday" value="<?php echo $client->birthday; ?>">
        </div> <!-- /form__field -->

        <div class="form__field">
            <label for="zipCode" class="form__label">Código Postal</label>
            <input class="form__input" type="text" placeholder="Tu Código Postal" id="zipCode" name="zipCode" value="<?php echo $client->zipCode; ?>">
        </div> <!-- /form__field -->

        <div class="form__field">
            <label for="address" class="form__label">Dirección Exacta</label>
            <input class="form__input" type="text" placeholder="Tu Dirección Exacta" id="address" name="address" value="<?php echo $client->address; ?>">
        </div> <!-- /form__field -->

        <div class="form__field">
            <label for="marketing" class="form__label">¿Recibir Información de Marketing?</label>
            <input 
                class="form__checkbox" 
                type="checkbox" 
                id="marketing" 
                name="marketing" 
                value="1" 
                <?php echo $client->marketing ? 'checked' : ''; ?>>
        </div> <!-- /form__field -->


        <input type="submit" class="orange-btn" value="Actualizar">
    </form>
</div>