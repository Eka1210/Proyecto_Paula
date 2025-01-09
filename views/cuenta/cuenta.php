<?php
    if($result){
        $message = showNotification(intval($result));
        if($message) { ?>
            <p class='alert success'> <?php echo s($message) ?> </p>;
        <?php }
    }
?>
<div class="info-cuenta">
    <div class="imagen-cuenta"></div>
    <div class="form-cuenta">
        <form class="form">
            <div class="form__field">
                <label for="name" class="form__label">Nombre Completo</label>
                <input disabled class="form__input" type="text" placeholder="Nombre completo" id="name" name="name" value="<?php echo $client->name . ' ' . $client->surname; ?>">
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
                <label for="password" class="form__label">Contraseña</label>
                <input disabled class="form__input" type="password" placeholder="Contraseña" id="password" name="password" value="<?php echo $user->password; ?>">
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
            <a href="/cuenta/actualizar" class="orange-btn">Actualizar</a>
            <a href="/change" class="orange-btn">Cambiar contraseña</a>
            <a href="/cuenta/eliminar" class="red-btn">Eliminar cuenta</a>
        </div>
    </div>
</div>
