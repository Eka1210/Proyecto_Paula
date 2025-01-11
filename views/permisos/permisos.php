<?php
    include_once __DIR__ . "/../templates/alerts.php";
?>

<div class="create-category">   
    <h1 class="create-category__title">Permisos de administrador</h1>
    <p class="permisos__description">Otorga permisos de administrador a un usuario especifico</p>
    
    <form method="POST" class="create-category__form">
        <div class="create-category__form__field">
            <label for="name" class="create-category__form__label">Username o Correo del Usuario</label>
            <input type="text" name="usuario" id="usuario" class="create-category__form__input" required>
        </div>
       
        <button type="submit" class="create-category__form__submit">Aceptar</button>
    </form>
</div>

