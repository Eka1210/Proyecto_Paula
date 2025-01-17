<div class="create-category">
    <h1 class="create-category__title">Generar Reporte</h1>
    <p class="create-category__description">Llena el siguiente formulario para generar reporte de ventas</p>

    <form method="POST" class="create-category__form">
        <div class="create-category__form__field">
            <label for="start_time" class="create-category__form__label">Fecha inicial:</label>
            <input type="date" id="start_time" name="start_time" max="<?php echo date('Y-m-d'); ?>" class="create-category__form__input" required>

            <label for="end_time" class="create-category__form__label">Fecha final:</label>
            <input type="date" id="end_time" name="end_time" max="<?php echo date('Y-m-d'); ?>" class="create-category__form__input" required>

            <button type="submit" class="create-category__form__submit">Export</button>
        </div>
    </form>
</div>