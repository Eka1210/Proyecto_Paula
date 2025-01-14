<div style="text-align: right; margin-right: 20px;">
    <a href="/admin/promocion/crear" class="form__submit--orange" style="display: inline-block;">
        Crear Promociones
    </a>
</div>
<?php var_dump($promociones) ?>

<div class="detalle">
    <h1 class="section__heading"><span> Gestión de Promociones </span></h1>
    <?php if (!empty($promociones)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Promociones</th>
                    <th scope="col" class="table__th"></th>
                    <th scope="col" class="table__th"></th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>
            <tbody class="table__tbody">
                <?php foreach ($promociones as $promocion) { ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $promocion->name; ?>
                        </td>
                        <td class="table__td">
                            <a href="/admin/editar/categoria?id=<?php echo $promocion->id; ?>" class="categoryCard__view">
                                <i class="fa-solid fa-pen-to-square"></i>
                                Editar Promocion
                            </a>
                        </td>
                        <td class="table__td">
                            <form action="/admin/categorias/eliminar" method="POST" onsubmit="return confirm('Está seguro que quiere eliminar la categoría?')">
                                <input type="hidden" name="id" value="<?php echo $promocion->id; ?>">
                                <button type="submit" class="categoryCard__view">
                                    <i class="fa-solid fa-trash"></i>
                                    Eliminar Promocion
                                </button>
                            </form>
                        </td>
                    </tr>

                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="admins__empty">No hay Promociones</p>
    <?php } ?>
</div>