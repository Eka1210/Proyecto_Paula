<?php
    include_once __DIR__ . "/../templates/alerts.php";
?>

<div class="create-category">
    <h1 class="create-category__title">Editar Método de Entrega <?php echo $nombre;?> </h1>
    <p class="create-category__description">Edite el siguiente formulario para actualizar el método de <?php echo $nombre;?></p>

    <form method="POST" class="create-category__form">
        <div class="create-category__form__field">
            <label for="name" class="create-category__form__label">Nombre del método de pago</label>
            <input type="text" name="name" value="<?php echo $nombre; ?>" id="name" class="create-category__form__input" required>
        </div>
        <div class="create-product_form_field">
            <label for="price" class="create-product_form_label">Costo</label>
            <input class="form__input" type="number" step="0.01" placeholder="Precio del Método" id="cost" name="cost" value="<?php echo $costo; ?>"; ?>
        </div>
        <div class="create-category__form__field">
            <label for="description" class="create-plan__form__label">Descripción</label>
            <textarea name="description" id="description" class="create-category__form__textarea" required><?php echo $descripcion; ?></textarea>
        </div>
        <button type="submit" class="edit-category__form__submit">Editar Método de Entrega</button>
    </form>
</div>