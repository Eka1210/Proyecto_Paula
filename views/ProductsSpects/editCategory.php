<?php
    include_once __DIR__ . "/../templates/alerts.php";
?>

<div class="create-category">
    <h1 class="create-category__title">Editar Categoría <?php echo $nombre;?> </h1>
    <p class="create-category__description">Edite el siguiente formulario para actualizar la Categoría de <?php echo $nombre;?></p>

    <form method="POST" class="create-category__form">
        <div class="create-category__form__field">
            <label for="name" class="create-category__form__label">Nombre de la Categoría</label>
            <input type="text" name="nombre" value="<?php echo $nombre;?>" id="name" class="create-category__form__input" required>
        </div>
        <div class="create-category__form__field">
            <label for="description" class="create-plan__form__label">Descripción</label>
            <textarea name="descripcion" id="description"  class="create-category__form__textarea" required><?php echo $descripcion;?></textarea>
        </div>

        <button type="submit" class="edit-category__form__submit">Editar Categoría</button>
    </form>
</div>