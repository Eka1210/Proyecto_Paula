<div class="create-category">
    <h1 class="create-category__title">Crear Promoción</h1>
    <p class="create-category__description">Llena el siguiente formulario para registrar un nuevo descuento</p>

    <form method="POST" class="create-category__form">
        <div class="create-category__form__field">
            <label for="name" class="create-category__form__label">Nombre del descuento</label>
            <input type="text" name="name" id="name" class="create-category__form__input" required>
        </div>
        <div class="create-category__form__field">
            <label for="description" class="create-category__form__label">Descripción</label>
            <textarea name="description" id="description" class="create-category__form__textarea" required></textarea>
        </div>
        <div class="create-category__form__field">
            <label for="percentage" class="create-category__form__label">Porcentaje del descuento</label>
            <input type="number" step="0.01" min="0" max="100.00" name="percentage" id="percentage" class="create-category__form__input" required>
        </div>
        <div class="create-category__form__field">
            <label for="start_time" class="create-category__form__label">Start Date:</label>
            <input type="date" id="start_time" name="start_time" min="<?php echo date('Y-m-d'); ?>" class="create-category__form__input">

            <label for="end_time" class="create-category__form__label">End Date:</label>
            <input type="date" id="end_time" name="end_time" min="<?php echo date('Y-m-d'); ?>" class="create-category__form__input">
        </div>


        <div class="create-category__form__field">
            <label class="create-category__form__label">Productos</label>
            <?php if (!empty($productos)) { ?>
                <table class="table">
                    <thead class="table__thead">
                        <tr>
                            <th scope="col" class="table__th">Nombre</th>
                            <th scope="col" class="table__th"></th>
                        </tr>
                    </thead>
                    <tbody class="table__tbody">
                        <?php foreach ($productos as $producto) { ?>
                            <tr class="table__tr">
                                <td class="table__td">
                                    <?php echo $producto->name; ?>
                                </td>
                                <td class="table__td">
                                    <input type="checkbox" name="listaProductos[]" value="<?php echo $producto->id; ?>">
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <p class="students__empty">No hay Productos Registrados</p>
            <?php } ?>
        </div>
        <button type="submit" class="create-category__form__submit">Crear Promocion</button>

    </form>


</div>

<!-- <script src="./dateValidator.js"></script> -->