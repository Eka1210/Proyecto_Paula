<?php
    include_once __DIR__ . "/../templates/alerts.php";
?>
<div class="create-product">
    <h1 class="create-category__title">Crear Producto</h1>
    <p class="create-product__description">Llena el siguiente formulario para registrar un nuevo Producto</p>
    <form method="POST" class="create-product__form"> 
        <div class="create-product__form__field">
            <label for="name" class="create-product__form__label">Nombre del Producto</label>
            <input class="form__input" type="text" placeholder="Nombre del Producto" id="name" name="name" value="<?php echo $producto->name ?? ''; ?>">
        </div> <!-- /form__field -->
        <div class="create-product__form__field">
            <label for="description" class="create-product__form__label">Descripción</label>
            <textarea class="form__textarea" name="description" id="description" placeholder="Descripción del Producto"><?php echo $producto->description ?? ''; ?></textarea>
        </div> <!-- /form__field -->
        <div class="create-product__form__field">
            <label for="price" class="create-product__form__label">Precio</label>
            <input class="form__input" type="number" step="0.01" placeholder="Precio del Producto" id="price" name="price" value="<?php echo $producto->price ?? ''; ?>">
        </div> <!-- /form__field -->
        <div class="create-product__form__field">
            <legend class="create-product__form__label">Categoría</legend>
            <?php if (!empty($categorias)) { ?>
                <table class="table">
                    <thead class="table__thead">
                        <tr>
                            <th scope="col" class="table__th">Nombre</th>
                            <th scope="col" class="table__th"></th>
                        </tr>
                    </thead>
                    <tbody class="table__tbody">
                        <?php foreach ($categorias as $categoria) { ?>
                            <tr class="table__tr">
                                <td class="table__td">
                                    <?php echo $categoria->nombre; ?>
                                </td>
                                <td class="table__td">
                                    <input type="checkbox" name="categories[]" value="<?php echo $categoria->id; ?>">
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <p class="students__empty">No hay Categorías registradas</p>
            <?php } ?>
        </div> <!-- /form__field -->
        <div class="create-product__form__field">
            <legend class="create-product__form__label">¿Por encargo?</legend>
            <select class="form__select" name="encargo" id="encargo">
                <option value="" disabled selected>-- Selecciona una Respuesta --</option>
                <option value=1>Sí</option>
                <option value=0>No</option>
            </select>
        </div> <!-- /form__field -->
        <div class="create-product__form__field cantidad-field" id="cantidadField">
            <label for="cantidad" class="create-product__form__label">Cantidad</label>
            <input class="form__input" type="number" placeholder="Cantidad disponible" id="cantidad" name="cantidad" min=1>
        </div> <!-- /form__field -->
        <button class="create-product__form__submit" type="submit" onclick="return confirm('Está seguro que quiere crear el producto')">Crear Producto</button>
    </form>
</div>

<style>
    .cantidad-field {
        visibility: hidden;
        height: 0;
        overflow: hidden;
    }

    .cantidad-field.visible {
        visibility: visible;
        height: auto;
    }
</style>

<script>
    document.querySelector('select[name="encargo"]').addEventListener('change', function() {
        const cantidadField = document.getElementById('cantidadField');
        if (this.value == '0') {
            cantidadField.classList.add('visible');
        } else {
            cantidadField.classList.remove('visible');
        }
    });
</script>