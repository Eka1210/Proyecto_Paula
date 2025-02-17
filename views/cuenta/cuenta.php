<?php
    if($result){
        $message = showNotification(intval($result));
        if($message) { ?>
            <p class='alert success'> <?php echo s($message) ?> </p>;
        <?php }
    }
    use Model\Usuario;
    $id = $_SESSION['userId'];
    $userActual = Usuario::find($id);
?>

<div class="consultar-cuenta">
    <div class="imagen-cuenta"></div>
    <div class="consultar-cuenta__form">
        <form class="form">
            <h1 class="consultar-cuenta__title">Información Personal</h1>

            <div class="form__field">
                <label for="name" class="form__label">Nombre</label>
                <input disabled class="form__input" type="text" placeholder="Nombre" id="name" name="name" value="<?php echo $client->name; ?>">
            </div> <!-- /form__field -->  

            <div class="form__field">
                <label for="name" class="form__label">Apellidos</label>
                <input disabled class="form__input" type="text" placeholder="Apellidos" id="surname" name="surname" value="<?php echo $client->surname; ?>">
            </div> <!-- /form__field -->  

            <div class="form__field">
                <label for="username" class="form__label">Nombre de Usuario</label>
                <input disabled class="form__input" type="text" placeholder="Nombre de usuario" id="username" name="username" value="<?php echo $user->username; ?>">
            </div> <!-- /form__field -->   

            <div class="form__field">
                <label for="phone" class="form__label">Teléfono</label>
                <input disabled class="form__input" type="tel" placeholder="Teléfono" id="phone" name="phone" value="<?php echo $client->phone; ?>">
            </div> <!-- /form__field -->   

            <div class="form__field">
                <label for="email" class="form__label">Correo Electrónico</label>
                <input disabled class="form__input" type="email" placeholder="Correo Electrónico" id="email" name="email" value="<?php echo $user->email; ?>">
            </div> <!-- /form__field -->        

            <div class="form__field">
                <label for="birthday" class="form__label">Fecha de Nacimiento</label>
                <input disabled class="form__input" type="text" placeholder="DD/MM/YYYY" id="birthday" name="birthday" value="<?php echo $client->birthday; ?>">
            </div> <!-- /form__field -->  

            <div class="form__field">
                <label for="zipCode" class="form__label">Código Postal</label>
                <input disabled class="form__input" type="text" placeholder="Código postal" id="zipCode" name="zipCode" value="<?php echo $client->zipCode; ?>">
            </div> <!-- /form__field -->

            <div class="form__field">
                <label for="address" class="form__label">Dirección Exacta</label>
                <input disabled class="form__input" type="text" placeholder="Dirección exacta" id="address" name="address" value="<?php echo $client->address; ?>">
            </div> <!-- /form__field -->

            <div class="form__field">
                <label for="marketing" class="form__label">Marketing</label>
                <input disabled class="form__input" type="text" placeholder="Preferencias de marketing" id="marketing" name="marketing" value="<?php echo $client->marketing ? 'Sí' : 'No'; ?>">
            </div><!-- /form__field -->        
        </form>
        <div class="acciones-cuenta">
            <a href="/cuenta/actualizar" class="orange-btn">Actualizar Información Personal</a>
            <a href="/change" class="orange-btn">Cambiar contraseña</a>
            <?php if ($userActual->username !== 'master') { ?>
                <a href="/cuenta/eliminar" class="red-btn" onclick="return confirm('Está seguro que quiere eliminar su cuenta')">Eliminar</a>
            <?php } ?>
        </div>
    </div>
</div>

