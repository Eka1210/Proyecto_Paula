<?php
include_once __DIR__ . "/../templates/alerts.php";
?>

<div class="create-promotion">
    <h1 class="create-promotion__title">Crear Promoción</h1>
    <p class="create-promotion__description">Llena el siguiente formulario para registrar un nuevo descuento</p>

    <form method="POST" class="create-promotion__form">
        <div class="create-promotion__form__field">
            <label for="name" class="create-promotion__form__label">Nombre del descuento</label>
            <input type="text" name="name" id="name" class="create-promotion__form__input" maxlength="44" required
                oninput="this.value = this.value.trim()">
        </div>
        <div class="create-promotion__form__field">
            <label for="description" class="create-promotion__form__label">Descripción</label>
            <input name="description" id="description" class="create-promotion__form__input" maxlength="49" required>
        </div>
        <div class="create-promotion__form__field">
            <label for="percentage" class="create-promotion__form__label">Porcentaje del descuento</label>
            <input type="number" step="0.01" min="0" max="100.00" name="percentage" id="percentage" class="create-promotion__form__input" required>
        </div>
        <div class="create-promotion__form__field">
            <label for="start_time" class="create-promotion__form__label">Fecha inicial:</label>
            <input type="date" id="start_time" name="start_time" min="<?php echo date('Y-m-d'); ?>" class="create-promotion__form__input" required>

            <label for="end_time" class="create-promotion__form__label">Fecha final:</label>
            <input type="date" id="end_time" name="end_time" min="<?php echo date('Y-m-d'); ?>" class="create-promotion__form__input" required>
        </div>


        <div class="create-promotion__form__field">
            <label class="create-promotion__form__label">Productos</label>
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
                                    <?php echo htmlspecialchars($producto->name); ?>
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
        <button type="submit" class="create-promotion__form__submit">Crear Promoción</button>

    </form>
</div>

<script>
    const startDateInput = document.getElementById('start_time');
    const endDateInput = document.getElementById('end_time');

    endDateInput.disabled = true;

    function formatDate(date) {
        return date.toISOString().split('T')[0];
    }

    startDateInput.addEventListener('change', () => {
        const startDate = new Date(startDateInput.value);
        const endDate = new Date(endDateInput.value);

        if (startDate) {
            endDateInput.disabled = false;

            const minEndDate = new Date(startDate);
            minEndDate.setDate(startDate.getDate() + 1);
            endDateInput.min = formatDate(minEndDate);

            if (endDate && endDate <= startDate) {
                endDateInput.value = formatDate(minEndDate);
            }
        } else {
            endDateInput.disabled = true;
            endDateInput.value = '';
        }
    });

    endDateInput.addEventListener('change', () => {
        const startDate = new Date(startDateInput.value);
        const endDate = new Date(endDateInput.value);

        if (endDate && endDate <= startDate) {
            const minEndDate = new Date(startDate);
            minEndDate.setDate(startDate.getDate() + 1);
            endDateInput.value = formatDate(minEndDate);
        }
    });
</script>