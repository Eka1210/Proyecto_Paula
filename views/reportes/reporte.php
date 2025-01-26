<?php
include_once __DIR__ . "/../templates/alerts.php";
?>

<div class="create-report">
    <h1 class="create-report__title">Generar Reporte</h1>
    <p class="create-report__description">Llena el siguiente formulario para generar el reporte de ventas</p>

    <form method="POST" class="create-report__form">
        <div class="create-report__form__field">
            <label for="start_time" class="create-report__form__label">Fecha inicial:</label>
            <input type="date" id="start_time" name="start_time" max="<?php echo date('Y-m-d'); ?>" class="create-report__form__input">

            <label for="end_time" class="create-report__form__label">Fecha final:</label>
            <input type="date" id="end_time" name="end_time" max="<?php echo date('Y-m-d'); ?>" class="create-report__form__input">

            <button type="submit" class="create-report__form__submit">Exportar</button>
        </div>
    </form>
</div>