<div class="create-category">
    <h1 class="create-category__title">Crear Método de Entrega</h1>
    <p class="create-category__description">Llena el siguiente formulario para registrar un nuevo método de pago</p>

    <form method="POST" class="create-category__form">
        <div class="create-category__form__field">
            <label for="name" class="create-category__form__label">Nombre del método</label>
            <input type="text" name="name" id="name" class="create-category__form__input" required>
        </div>
        <div class="create-category__form__field">
            <label for="cost" class="create-category__form__label">Costo</label>
            <input type="text" name="cost" id="cost" class="create-category__form__input" required>
        </div>
        <div class="create-category__form__field">
            <label for="description" class="create-category__form__label">Descripción</label>
            <textarea name="description" id="description" class="create-category__form__textarea" required></textarea>
        </div>
        <button type="submit" class="create-category__form__submit">Crear Método de pago</button>
    </form>
</div>