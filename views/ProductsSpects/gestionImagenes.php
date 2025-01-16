<?php
    include_once __DIR__ . "/../templates/alerts.php";
?>
<div style="display: flex; justify-content: space-between; align-items: flex-start;">
    <div class="detalle2">   
        <h1 class="section__heading"><span> Gestión de Imagen de Producto  </span></h1>
        <?php if(!empty($productos)){ ?>
                <table class="table">
                    <thead class="table__thead">
                        <tr>
                            <th scope="col" class="table__th">Producto</th>
                            <th scope="col" class="table__th">Imagen</th>
                            <th scope="col" class="table__th"></th>
                            <th scope="col" class="table__th"></th>
                        </tr>
                    </thead>
                    <tbody class="table__tbody">
                        <?php foreach($productos as $producto){?>
                            <tr class="table__tr">
                                <td class="table__td">
                                    <?php echo $producto->name; ?>
                                </td>
                                <td class="table__td">
                                    <?php if (!empty($producto->imagen)) { ?>
                                        <img src="<?php echo htmlspecialchars($producto->imagen);?>" alt="Imagen de <?php echo htmlspecialchars($producto->name); ?>" style="width: 100px; height: 100px;">
                                    <?php } else { ?>
                                        <span>No tiene</span>
                                    <?php } ?>
                                </td>
                                <td class="table__td">
                                    <form class="image-form" enctype="multipart/form-data">
                                        <input type="hidden" name="id" value="<?php echo $producto->id; ?>">
                                        <div class="custom-file-upload">
                                            <label for="file-<?php echo $producto->id; ?>" class="categoryCard__view">
                                                <i class="fas fa-upload"></i> Seleccionar Imagen
                                            </label>
                                            <input type="file" name="image" id="file-<?php echo $producto->id; ?>" class="image-input" style="Display:none">
                                        </div>

                                        <button type="button" class="categoryCard__view">
                                            <i class="fas fa-cloud-upload-alt"></i> Subir
                                        </button>
                                    </form>
                                </td>
                                <td class="table__td">
                                    <form class="delete-form" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $producto->id; ?>">
                                        <button type="submit" class="categoryCard__view">
                                            <i class="fa-solid fa-trash"></i>
                                            Eliminar Imagen
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            
                        <?php }?>
                    </tbody>
                </table>
        <?php } else { ?>
            <p class="admins__empty">No hay Productos</p>
        <?php } ?>
    </div>

    <div class="detalle2">   
        <h1 class="section__heading"><span> Gestión de Imagen de Categoría  </span></h1>
        <?php if(!empty($categorias)){ ?>
                <table class="table">
                    <thead class="table__thead">
                        <tr>
                            <th scope="col" class="table__th">Categoría</th>
                            <th scope="col" class="table__th">Imagen</th>
                            <th scope="col" class="table__th"></th>
                            <th scope="col" class="table__th"></th>
                        </tr>
                    </thead>
                    <tbody class="table__tbody">
                        <?php foreach($categorias as $categoria){?>
                            <tr class="table__tr">
                                <td class="table__td">
                                    <?php echo $categoria->nombre; ?>
                                </td>
                                <td class="table__td">
                                    <?php if (!($categoria->imagen == ' ') and !($categoria->imagen == '')) { ?>
                                        <img src="<?php echo htmlspecialchars($categoria->imagen);?>" alt="Imagen de <?php echo htmlspecialchars($categoria->nombre); ?>" style="width: 100px; height: 100px;">
                                    <?php } else { ?>
                                        <span>No tiene</span>
                                    <?php } ?>
                                </td>
                                <td class="table__td">
                                    <form class="image-form2" enctype="multipart/form-data">
                                        <input type="hidden" name="id" value="<?php echo $categoria->id; ?>">
                                        <div class="custom-file-upload">
                                            <label for="file-<?php echo $categoria->id; ?>" class="categoryCard__view">
                                                <i class="fas fa-upload"></i> Seleccionar Imagen
                                            </label>
                                            <input type="file" name="image" id="file-<?php echo $categoria->id; ?>" class="image-input2" style="Display:none">
                                        </div>

                                        <button type="button" class="categoryCard__view">
                                            <i class="fas fa-cloud-upload-alt"></i> Subir
                                        </button>
                                    </form>
                                </td>
                                <td class="table__td">
                                    <form class="delete-form2" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $categoria->id; ?>">
                                        <button type="submit" class="categoryCard__view">
                                            <i class="fa-solid fa-trash"></i>
                                            Eliminar Imagen
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            
                        <?php }?>
                    </tbody>
                </table>
        <?php } else { ?>
            <p class="admins__empty">No hay Categorias</p>
        <?php } ?>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Lógica para el formulario de imagen de producto
        const forms = document.querySelectorAll('.image-form, .image-form2');

        forms.forEach(form => {
            const uploadButton = form.querySelector('button[type="button"]');
            const fileInput = form.querySelector('input[type="file"]');

            uploadButton.addEventListener('click', async (event) => {
                event.preventDefault();

                const formData = new FormData(form);
                const id = formData.get('id');
                const imageFile = fileInput.files[0];

                if (!imageFile) {
                    alert('Por favor selecciona una imagen.');
                    return;
                }

                formData.append('image', imageFile);

                try {
                    const response = await fetch(`/admin/imagenes${form.classList.contains('image-form2') ? 'C' : ''}/subir?id=${id}`, {
                        method: 'POST',
                        body: formData
                    });

                    const result = await response.json();

                    if (response.ok) {
                        alert('Imagen subida exitosamente.');
                        location.reload(); // Refresca la página para actualizar la vista
                    } else {
                        alert(result.error || 'Ocurrió un error al subir la imagen.');
                    }
                } catch (error) {
                    console.error('Error al subir la imagen:', error);
                    alert('Hubo un problema al subir la imagen.');
                }
            });
        });

        // Lógica para el formulario de eliminar imagen
        const deleteForms = document.querySelectorAll('.delete-form, .delete-form2');
        deleteForms.forEach(deleteForm => {
            deleteForm.addEventListener('submit', async (event) => {
                event.preventDefault();

                if (!confirm('¿Estás seguro que deseas eliminar esta imagen?')) {
                    return;
                }

                const formData = new FormData(deleteForm);
                const id = formData.get('id');

                try {
                    const response = await fetch(`/admin/imagenes${deleteForm.classList.contains('delete-form2') ? 'C' : ''}/eliminar?id=${id}`, {
                        method: 'POST',
                        body: formData
                    });

                    const result = await response.json();

                    if (response.ok) {
                        alert('Imagen eliminada exitosamente.');
                        location.reload(); // Refresca la página para actualizar la vista
                    } else {
                        alert(result.error || 'Ocurrió un error al eliminar la imagen.');
                    }
                } catch (error) {
                    console.error('Error al eliminar la imagen:', error);
                    alert('Hubo un problema al eliminar la imagen.');
                }
            });
        });
    });

</script>