<div style="text-align: right; margin-right: 20px;">
    <a href="/admin/inventario/crear" class="form__submit--orange" style="display: inline-block;">
        Crear Registro de Inventario
    </a>
</div>


<div class="detalle" style='margin-bottom: 2rem;'>
    <h1 class="section__heading"><span> Inventario </span></h1>
    <?php if (!empty($productos)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Producto</th>
                    <th scope="col" class="table__th">Cantidad</th>
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
                            <?php echo htmlspecialchars($producto->cantidad); ?>
                        </td>
                        <td class="table__td">
                            <a href="/admin/inventario/log?id=<?php echo $producto->id; ?>" class="categoryCard__view">
                                <i class="fa-solid fa-pen-to-square"></i>
                                Ver Historial
                            </a>
                        </td>
                    </tr>

                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="admins__empty">No hay Productos</p>
    <?php } ?>
</div>