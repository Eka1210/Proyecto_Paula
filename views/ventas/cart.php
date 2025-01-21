<h1 style="text-align: center;">Carrito</h1>

<?php if (!empty($productos)) : ?>
    <table class="products cart">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Imagen</th>
                <th>Precio Unitario</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
                <th>Categorías</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            <?php 
            // Variables para total de productos y monto total
            $totalProductos = 0;
            $totalMonto = 0;

            foreach ($productos as $producto) {
                // Calcular subtotal por producto
                $subtotal = $producto->price * $producto->quantity;
                $totalProductos += $producto->quantity;
                $totalMonto += $subtotal;
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($producto->name); ?></td>
                    <td>
                        <img src="<?php echo htmlspecialchars($producto->imagen); ?>" 
                             alt="Imagen de <?php echo htmlspecialchars($producto->name); ?>" 
                             class="table-image">
                    </td>
                    <td>₡<?php echo number_format($producto->price, 2); ?></td>
                    <td><?php echo htmlspecialchars($producto->quantity); ?></td>
                    <td>₡<?php echo number_format($subtotal, 2); ?></td>
                    <td>
                        <?php 
                        if (!empty($producto->categories)) {
                            foreach ($producto->categories as $categoria) {
                                echo htmlspecialchars($categoria->nombre) . "<br>";
                            }
                        }
                        ?>
                    </td>
                    <td>
                        <form method="POST" action="/cart/AddToCart" class="w-100">
                            <input type="hidden" value="<?php echo $producto->id; ?>" id="producto" name="producto">
                            <input type="hidden" value="<?php echo $producto->price; ?>" id="price" name="price">
                            <input type="hidden" value="<?php echo 1; ?>" id="quantity" name="quantity">
                            <button type="submit" class="icon-update" title="Añadir al carrito">+</button>
                        </form>
                        <form method="POST" action="/cart/removeFromCart" class="w-100">
                            <input type="hidden" name="productID" value="<?php echo htmlspecialchars($producto->id); ?>">
                            <button type="submit" class="icon-delete" title="Eliminar del carrito">-</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="info-carrito">
        <p>Cantidad de productos: <span><?php echo $totalProductos; ?></span></p>
        <p class="total">Total: <span>₡<?php echo number_format($totalMonto, 2); ?></span></p>

        <form action="/cart/checkout" method="POST" onsubmit="return confirm('Está seguro que quiere confirmar estos productos?')">
            <input type="hidden" name="totalMonto" value="<?php echo $totalMonto; ?>">
            <input type="submit" class="send-cart" value="Continuar">
        </form>
    </div>
<?php else : ?>
    <p class="admins__empty">No hay productos en el carrito</p>
<?php endif; ?>