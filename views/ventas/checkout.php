<?php
include_once __DIR__ . "/../templates/alerts.php";
?>


<h1 style="text-align: center;">Checkout</h1>

<div class="checkout">
    <h2 class="checkout-title" style="margin-left: 10px;">Resumen del Carrito</h2>

    <?php if (!empty($productos)) : ?>
        <table class="products checkout">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Subtotal(Sin descuento)</th>
                    <th>Descuento(Por total de productos)</th>
                    <th>Total(Con descuento)</th>
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
            <h2  style="margin-left: 10px;"><span>Métodos de Pago</span></h2>
            <div class="payment-methods" style="margin-left: 10px;">
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

            <h2 class="checkout-title"  style="margin-left: 10px;">Métodos de Entrega</h2>
            <div class="delivery-methods" style="margin-left: 10px;">
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

            <div class="info-carrito">
                <p> Subtotal: <span>₡<?php echo number_format($totalMonto, 2); ?></span></p>
                <?php if ($descuento > 0) : ?>
                    <p id="descuento-info"  style="margin-bottom: 20px;">
                    Descuento aplicado: <strong>₡<?php echo number_format($descuento, 2); ?></strong>
                    </p>
                <?php endif; ?>
                <p class = "total" style="margin-bottom: 3rem;">Total a pagar: <span id="total-pagar">₡<?php echo number_format($totalMonto - $descuento, 2); ?></span></p>
            

            <input type="hidden" value="<?php echo $descuento; ?>" name="descuento">
            <input type="hidden" value="<?php echo ($totalMonto - $descuento); ?>" name="totalMonto">

            <button type="submit" class="send-cart">Realizar Pedido</button>
            </div>
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