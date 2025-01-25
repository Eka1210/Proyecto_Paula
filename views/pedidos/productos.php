

<div class='detalle'>
    <h1 class="section__heading"><span> Productos del Pedido #<?php echo htmlspecialchars($pedidoId); ?> </span></h1>
    <?php if (!empty($productos)) { ?>
    <table class="table" >
        <thead class="table__thead">
            <tr>
                <th scope="col" class="table__th">Producto</th>
                <th scope="col" class="table__th">Descripción</th>
                <th scope="col" class="table__th">Cantidad</th>
                <th scope="col" class="table__th">Precio Unitario</th>
                <th scope="col" class="table__th">Subtotal</th>
            </tr>
        </thead>
        <tbody class="table__tbody">
            <?php foreach ($productos as $producto) { ?>
                <tr class="table__tr">
                    <td class="table__td">
                        <?php echo htmlspecialchars($producto->productName); ?>
                    </td>
                    <td class="table__td">
                        <?php echo htmlspecialchars($producto->description); ?>
                    </td>
                    <td class="table__td">
                        <?php echo htmlspecialchars($producto->quantity); ?>
                    </td>
                    <td class="table__td">
                        ₡<?php echo number_format($producto->unitPrice, 2); ?>
                    </td>
                    <td class="table__td">
                        ₡<?php echo number_format(($producto->unitPrice * $producto->quantity), 2); ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } else { ?>
    <p class="admins__empty">No hay productos asociados a este pedido.</p>
<?php } ?>
</div>