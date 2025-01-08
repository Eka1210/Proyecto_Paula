<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<h1 style="text-align: center;">Productos</h1>
<div class="products-list">
    <?php foreach($productos as $producto) { ?>
        <div class="product">
            <div class="product-image">
                <img src="<?php echo htmlspecialchars($producto->imagen); ?>" alt="Imagen del Anuncio" style="display: block; margin: 0 auto;">
            </div>
            <p><?php echo htmlspecialchars($producto->name); ?></p>
            <p class="precio">₡<?php echo htmlspecialchars($producto->price); ?> I.V.A.I</p>

            
            <?php if($producto->encargo == 1) { ?>
                <form action="/personalizar/producto" method="get">
                    <input type="hidden" value="<?php echo htmlspecialchars($producto->id); ?>" name="id">
                    <button class="personalizar" type="submit">Personalizar</button>
                </form>
            <?php } else { ?>
                <form method="post" style="margin-bottom: 10px;">
                    <input type="hidden" value="<?php echo htmlspecialchars($producto->id); ?>" id="producto" name="producto">
                    <button class="cart-button" type="submit" id="addToCartButton" data-product="<?php echo htmlspecialchars($producto->id); ?>">Agregar al Carrito</button>
                </form>
            <?php } ?>

        </div>
    <?php } ?>
</div>
