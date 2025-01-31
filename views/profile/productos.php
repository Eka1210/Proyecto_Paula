<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<h1 style="text-align: center;">Productos</h1>
<div class="products-list">
    <?php if (!empty($productos)) { ?>
        <?php foreach ($productos as $producto) { ?>
            <?php if ($producto->activo == 1) { ?>
                <div class="product">
                    <a href="/mostrarproducto?nombre=<?php echo $producto->name; ?>">
                        <div class="product-image">
                            <img src="<?php echo htmlspecialchars($producto->imagen); ?>" alt="Imagen del Anuncio" style="display: block; margin: 0 auto;">
                        </div>
                    </a>
                    <div class="product-details">
                        <p style="margin-top: 15px; margin-bottom: 15px;"><?php echo htmlspecialchars($producto->name); ?></p>
                        <?php
                        if ($producto->discountPercentage > 0) {
                            $discountedPrice = $producto->price - ($producto->price * $producto->discountPercentage / 100);
                        ?>
                            <p class="precio" style="color: green;">₡<?php echo number_format($discountedPrice, 2); ?> I.V.A.I</p>
                            <p class="precio" style="text-decoration: line-through; font-size: 1em;">₡<?php echo number_format($producto->price, 2); ?></p>
                        <?php
                        } else {
                        ?>
                            <p class="precio">₡<?php echo number_format($producto->price, 2); ?> I.V.A.I</p>
                        <?php
                        }
                        ?>
                        <?php if ($producto->encargo == 1) { ?>
                            <a href="/mostrarproducto?nombre=<?php echo $producto->name; ?>" style="margin-top: 20px; font-size: 24px; color:  var(--dorado); font-weight: bold;">Personalizar</a>

                        <?php } else { ?>
                            <form action="cart/AddToCart" method="post" style="margin-bottom: 10px;">
                                <input type="hidden" value="<?php echo htmlspecialchars($producto->id); ?>" id="producto" name="producto">
                                <input type="hidden" value="<?php echo htmlspecialchars($producto->price); ?>" id="price" name="price">
                                <div class="quantity-selector">
                                    <label for="quantity">Cantidad:</label>
                                    <select id="quantity" name="quantity">
                                        <?php
                                        for ($i = 1; $i <= $producto->cantidad; $i++) {
                                            echo '<option value="' . htmlspecialchars($i) . '">' . htmlspecialchars($i) . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <button class="cart-button" type="submit" id="addToCartButton" data-product="<?php echo htmlspecialchars($producto->id); ?>">Agregar al Carrito</button>
                            </form>


                        <?php } ?>
                    </div>
                </div>
            <?php } ?>


        <?php } ?>
    <?php } else { ?>
        <p class="admins__empty">No hay Productos</p>
    <?php } ?>
</div>


<script>
    document.addEventListener('DOMContentLoaded', () => {
    const cartButtons = document.querySelectorAll('.cart-button');
    const cartCountElement = document.getElementById('cart-count');

    cartButtons.forEach(button => {
        button.addEventListener('click', async (event) => {
            event.preventDefault(); // Evita la recarga de página
            const productId = button.dataset.product; // ID del producto
            const quantity = button.closest('form').querySelector('#quantity').value;

            // Llamada a PHP para agregar al carrito
            const response = await fetch('cart/AddToCart', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `producto=${productId}&quantity=${quantity}`
            });

            if (response.ok) {
                // Simula obtener el total de productos en el carrito
                const data = await response.json();
                cartCountElement.textContent = data.totalItems; // Actualiza la burbuja
            } else {
                alert('No se pudo agregar el producto al carrito');
            }
        });
    });
});

</script>