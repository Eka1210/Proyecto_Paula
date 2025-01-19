<h1 style="text-align: center;">Checkout</h1>

<div class="checkout">
    <h2 class="checkout-title">Resumen del Carrito</h2>

    <?php if (!empty($productos)) : ?>
        <table class="products checkout">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($productos as $producto) {
                    // Calcular subtotal por producto
                    $subtotal = $producto->price * $producto->quantity;
                    $totalProductos += $producto->quantity;
                    $totalMonto += $subtotal;
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($producto->name); ?></td>
                        <td><?php echo htmlspecialchars($producto->quantity); ?></td>
                        <td>₡<?php echo number_format($producto->price, 2); ?></td>
                        <td>₡<?php echo number_format($subtotal, 2); ?></td>
                    </tr>
                <?php } ?>
            </tbody>


        </table>

        <div class="checkout-summary">
            <p>Total: <strong>₡<?php echo number_format($totalMonto, 2); ?></strong></p>
            <?php if ($descuento > 0) : ?>
                <p>Descuento aplicado: <strong>₡<?php echo number_format($descuento, 2); ?></strong></p>
                <p>Total a pagar: <strong>₡<?php echo number_format($totalMonto - $descuento, 2); ?></strong></p>
            <?php else : ?>
                <p>Total a pagar: <strong>₡<?php echo number_format($totalMonto, 2); ?></strong></p>
            <?php endif; ?>
        </div>

        <h2 class="checkout-title">Métodos de Pago</h2>
        <ul class="payment-methods">
            <?php foreach ($metodosPago as $metodo) : ?>
                <li>
                    <strong><?php echo htmlspecialchars($metodo->name); ?></strong>: 
                    <?php echo htmlspecialchars($metodo->description); ?>
                </li>
            <?php endforeach; ?>
        </ul>

        <h2 class="checkout-title">Métodos de Entrega</h2>
        <ul class="delivery-methods">
            <?php foreach ($metodosEntrega as $metodo) : ?>
                <li>
                    <strong><?php echo htmlspecialchars($metodo->name); ?></strong>: 
                    <?php echo htmlspecialchars($metodo->description); ?> 
                    (Costo: ₡<?php echo number_format($metodo->cost, 2); ?>)
                </li>
            <?php endforeach; ?>
        </ul>

        <form action="/cart/confirmOrder" method="POST" onsubmit="return confirm('¿Está seguro de confirmar el pedido?')">
            <button type="submit" class="checkout-button">Generar Pedido</button>
        </form>
    <?php else : ?>
        <p class="checkout-empty">No hay productos en el carrito.</p>
    <?php endif; ?>
</div>
