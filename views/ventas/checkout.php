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
                    <th>Subtotal(Sin descuento)</th>
                    <th>Descuento</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($producto->name); ?></td>
                        <td><?php echo htmlspecialchars($producto->quantity); ?></td>
                        <td>₡<?php echo number_format($producto->price, 2); ?></td>
                        <td>₡<?php echo number_format($producto->price * $producto->quantity, 2); ?></td>
                        <td>
                            <?php if (!empty($producto->discount)) : ?>
                                <?php echo $producto->discountPercentage; ?>% (₡<?php echo number_format($producto->discount, 2); ?>)
                            <?php else : ?>
                                Sin descuento
                            <?php endif; ?>
                        </td>
                        <td>₡<?php echo number_format(($producto->price * $producto->quantity) - $producto->discount, 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <form method="POST" action="/cart/confirmOrder" onsubmit="return confirm('¿Está seguro de confirmar el pedido?')">
            <h2 class="checkout-title">Métodos de Pago</h2>
            <div class="payment-methods">
                <?php foreach ($metodosPago as $metodo) : ?>
                    <div>
                        <input 
                            type="radio" 
                            id="payment-<?php echo $metodo->id; ?>" 
                            name="paymentMethod" 
                            value="<?php echo $metodo->id; ?>" 
                            required
                        >
                        <label for="payment-<?php echo $metodo->id; ?>">
                            <strong><?php echo htmlspecialchars($metodo->name); ?></strong>: 
                            <?php echo htmlspecialchars($metodo->description); ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>

            <h2 class="checkout-title">Métodos de Entrega</h2>
            <div class="delivery-methods">
                <?php foreach ($metodosEntrega as $metodo) : ?>
                    <div>
                        <input 
                            type="radio" 
                            id="delivery-<?php echo $metodo->id; ?>" 
                            name="deliveryMethod" 
                            value="<?php echo $metodo->id; ?>" 
                            required
                            onchange="updateTotal(<?php echo $metodo->cost; ?>)"
                        >
                        <label for="delivery-<?php echo $metodo->id; ?>">
                            <strong><?php echo htmlspecialchars($metodo->name); ?></strong>: 
                            <?php echo htmlspecialchars($metodo->description); ?> 
                            (Costo: ₡<?php echo number_format($metodo->cost, 2); ?>)
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="checkout-summary">
                <p>Total: <strong>₡<?php echo number_format($totalMonto, 2); ?></strong></p>
                <p id="descuento-info">
                    <?php if ($descuento > 0) : ?>
                        Descuento aplicado: <strong>₡<?php echo number_format($descuento, 2); ?></strong>
                    <?php endif; ?>
                </p>
                <p>Total a pagar: <strong id="total-pagar">₡<?php echo number_format($totalMonto - $descuento, 2); ?></strong></p>
            </div>

            <input type="hidden" value="<?php echo $descuento; ?>" name="descuento">
            <input type="hidden" value="<?php echo ($totalMonto - $descuento); ?>" name="totalMonto">

            <button type="submit" class="btn btn-primary">Realizar Pedido</button>
        </form>
    <?php else : ?>
        <p class="checkout-empty">No hay productos en el carrito.</p>
    <?php endif; ?>
</div>

<script>
    function updateTotal(deliveryCost) {
        const totalBase = <?php echo $totalMonto; ?>;
        const discount = <?php echo $descuento; ?>;
        const totalToPay = totalBase - discount + deliveryCost;
        document.getElementById('total-pagar').textContent = `₡${totalToPay.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
        // Actualizar el valor del input oculto para enviar el total correcto
        document.getElementById('totalMonto').value = totalToPay;
    }
</script>