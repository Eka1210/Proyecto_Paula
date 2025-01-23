<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<h1 style="text-align: center;">Productos de Categoría: <?php echo $categoria->nombre; ?></h1>
<div class="products-list">
    <?php if (!empty($productos)) { ?>
        <?php foreach ($productos as $producto) { ?>
            <div class="product">
                <div class="product-image">
                    <img src="<?php echo htmlspecialchars($producto->imagen); ?>" alt="Imagen del Anuncio" style="display: block; margin: 0 auto;">
                </div>
                <p><?php echo htmlspecialchars($producto->name); ?></p>
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
                    <form action="/personalizar/producto" method="get">
                        <input type="hidden" value="<?php echo htmlspecialchars($producto->id); ?>" name="id">
                        <button class="personalizar" type="submit">Personalizar</button>
                    </form>
                <?php } else { ?>
                    <form action="cart/AddToCart" method="post" style="margin-bottom: 10px;">
                        <input type="hidden" value="<?php echo htmlspecialchars($producto->id); ?>" id="producto" name="producto">
                        <input type="hidden" value="<?php echo htmlspecialchars($producto->price); ?>" id="price" name="price">
                        <input type="hidden" value="<?php echo htmlspecialchars(1); ?>" id="quantity" name="quantity">
                        <button class="cart-button" type="submit" id="addToCartButton" data-product="<?php echo htmlspecialchars($producto->id); ?>">Agregar al Carrito</button>
                    </form>
                <?php } ?>

            </div>
        <?php } ?>
    <?php } else { ?>
        <p class="admins__empty">No hay Productos</p>
    <?php } ?>

</div>