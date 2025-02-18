<div class="create-category">
    <h1 class="create-category__title">Crear Nueva Opción</h1>
    <form method="POST" class="create-category__form">
        <!-- Campo para el nombre de la opción -->
        <div class="create-category__form__field">
            <label for="name" class="create-category__form__label">Nombre de la Opción</label>
            <input type="text" name="nombre" id="name" class="create-category__form__input" required>
        </div>

        <!-- Contenedor de valores dinámicos -->
        <div id="dynamic-values">
            <div class="create-category__form__field dynamic-value">
                <label class="create-category__form__label">Valor</label>
                <input type="text" name="values[]" class="create-category__form__input" required>
                <button type="button" class="delete-value-btn" style="margin-bottom: 15px">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>

        <!-- Botón para agregar valores -->
        <button type="button" id="add-value-btn" class="categoryCard__view">
            <i class="fa-solid fa-plus"></i> Agregar Valor
        </button>

        <!-- Botón para enviar el formulario -->
        <button type="submit" class="create-category__form__submit">Crear Opción</button>
    </form>
</div>
<style>
    .delete-value-btn {
        color: #693334;
        border-radius: 2rem;
        display: flex;
        justify-content: space-between;
        align-text: right;
        gap: 2rem;
    }
    #add-value-btn {
        margin-bottom: 1.5rem; /* Espacio inferior entre el botón y otros elementos */
    }
</style>

<script>
    // Agregar nuevos campos dinámicos
    document.getElementById('add-value-btn').addEventListener('click', function () {
        const container = document.getElementById('dynamic-values');
        const newField = document.createElement('div');
        newField.classList.add('create-category__form__field', 'dynamic-value');
        newField.innerHTML = `
            <label class="create-category__form__label">Valor</label>
            <input type="text" name="values[]" class="create-category__form__input" required>
            <button type="button" class="delete-value-btn" style="margin-bottom: 15px">
                <i class="fa-solid fa-trash"></i>
            </button>
        `;
        container.appendChild(newField);

        // Añadir evento al botón de borrar
        newField.querySelector('.delete-value-btn').addEventListener('click', function () {
            newField.remove();
        });
    });

    // Borrar los campos existentes al cargar
    document.querySelectorAll('.delete-value-btn').forEach(button => {
        button.addEventListener('click', function () {
            button.parentElement.remove();
        });
    });
</script>
