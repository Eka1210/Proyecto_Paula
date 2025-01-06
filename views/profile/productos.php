<h1 style="text-align: center;">Productos</h1>
<div class="products-list">
    <?php foreach($productos as $producto) { ?>
        <div class="product">
            <div class="product-image">
                <img src="<?php echo htmlspecialchars($producto->imagen);?>" alt="Imagen del Anuncio" style="display: block; margin: 0 auto;">
            </div>
            <p> <?php echo $producto->name; ?> </p>
            <p class="precio">₡<?php echo $producto->price; ?> I.V.A.I</p>
            <form method="post">
                <input type="hidden" value="<?php echo $producto->id; ?>" id="producto" name="producto">
                <button class="cart-button" type="submit" id="addToCartButton" data-product=<?php echo $producto->id; ?>>Agregar al Carrito</button>
            </form>
        </div>
    <?php } ?>
</div>
