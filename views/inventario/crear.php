<?php
include_once __DIR__ . "/../templates/alerts.php";
?>

<div class="create-category">
    <h1 class="create-category__title">Crear Registro del Inventario</h1>
    <p class="create-category__description">Llena el siguiente formulario para registrar un movimiento en el inventario</p>

    <form method="POST" class="create-category__form">

        <div class="create-category__form__field">
            <label for="product" class="create-category__form__label">Producto</label>

            <select id="product" name="product" style="margin-bottom: 10px;" required>
                <option value="">Seleccionar Producto</option>
                <?php foreach ($productos as $producto): ?>
                    <option value="<?php echo $producto->id; ?>"><?php echo $producto->name; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="create-category__form__field">
            <label for="action" class="create-category__form__label">Motivo de Movimiento</label>
            <input type="text" name="action" id="action" class="create-category__form__input" required placeholder="Motivo de Movimiento" maxlength="44">
        </div>
        <div class="create-category__form__field">
            <label for="quantity" class="create-category__form__label">Cantidad del movimiento</label>
            <input type="number" step="1" min="1" max='999999' name="quantity" id="quantity" class="create-category__form__input" required placeholder="Cantidad de producto">
        </div>
        <div class="create-category__form__field">
            <label class="create-category__form__label">
                <input class="create-category__form__label" type="radio" name="isIncrementing" value=1 checked> Incrementar
            </label>
            <label class="create-category__form__label">
                <input class="create-category__form__label" type="radio" name="isIncrementing" value=0> Disminuir
            </label>
        </div>


        <button type="submit" class="create-category__form__submit">Crear Registro</button>

    </form>
</div>