<?php
    include_once __DIR__ . "/../templates/alerts.php";
?>
<div class="create-category">
    <h1 class="create-category__title">Crear Categoría</h1>
    <p class="create-category__description">Llena el siguiente formulario para registrar una nueva Categoría</p>

    <form method="POST" class="create-category__form">
        <div class="create-category__form__field">
            <label for="name" class="create-category__form__label">Nombre de la Categoría</label>
            <input type="text" name="nombre" id="name" class="create-category__form__input" required>
        </div>
        <div class="create-category__form__field">
            <label for="description" class="create-category__form__label">Descripción</label>
            <textarea name="descripcion" id="description" class="create-category__form__textarea" required></textarea>
        </div>

        <button type="submit" class="create-category__form__submit">Crear Categoría</button>
    </form>
</div>