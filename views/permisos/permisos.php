<?php
    include_once __DIR__ . "/../templates/alerts.php";
?>

<div class="create-category">   
    <h1 class="create-category__title">Permisos de administrador</h1>
    <p class="permisos__description">Otorga o revoca permisos de administrador a un usuario específico</p>
    
    <form method="POST" class="create-category__form">
        <div class="create-category__form__field">
            <label for="name" class="create-category__form__label">Username o Correo del Usuario</label>
            <input type="text" name="usuario" id="usuario" class="create-category__form__input" required>
        </div>
        <div class="acciones-cuenta">
        </div>
            <button type="submit" name="accion" value="otorgar" class="orange-btn" onclick="return confirm('Está seguro que quiere otorgar permisos a este usuario')">Otorgar</button>

            <button type="submit" name="accion" value="revocar" class="red-btn" onclick="return confirm('Está seguro que quiere revocar los permisos de este usuario')">Revocar</button>
        
    </form>
</div>

