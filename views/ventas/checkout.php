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
        <h2 class="checkout-title">Métodos de Pago</h2>
            <form method="POST" action="/checkout/submit">
                <div class="payment-methods">
                    <?php foreach ($metodosPago as $metodo) : ?>
                        <div>
                            <input 
                                type="radio" 
                                id="payment-<?php echo $metodo->id; ?>" 
                                name="metodoPago" 
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
                        name="metodoEntrega" 
                        value="<?php echo $metodo->cost; ?>" 
                        required 
                        class="delivery-option"
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
            <?php if ($descuento > 0) : ?>
                <p>Descuento aplicado: <strong>₡<?php echo number_format($descuento, 2); ?></strong></p>
                <p>Total a pagar: 
                    <strong id="total-pagar">₡<?php echo number_format($totalMonto - $descuento, 2); ?></strong>
                </p>
            <?php else : ?>
                <p>Total a pagar: 
                    <strong id="total-pagar">₡<?php echo number_format($totalMonto, 2); ?></strong>
                </p>
            <?php endif; ?>
        </div>
        <form action="/cart/confirmOrder" method="POST" onsubmit="return confirm('¿Está seguro de confirmar el pedido?')">
                <button type="submit" class="btn btn-primary">Realizar Pedido</button>
        </form>
    <?php else : ?>
        <p class="checkout-empty">No hay productos en el carrito.</p>
    <?php endif; ?>
</div>
