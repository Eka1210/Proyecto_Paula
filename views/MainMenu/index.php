<div class="publicidad">
    <p class="flecha"> < </p>
    <div class="contenido-publicidad">
    </div>
    <p class="flecha"> > </p>
</div>



<h1 style="text-align: center;">Productos Destacados</h1>
<div class="container-info">
    <div class="products-list">
        <?php foreach($productos as $producto) { ?>
            <div class="product">
                <div class="product-image">
                    <img src="<?php echo htmlspecialchars($producto->imagen); ?>" alt="Imagen del Anuncio"  style="display: block; margin: 0 auto;">
                </div>
                <div class="contenido-anuncio">
                    <p> <?php echo $producto->name; ?> </p>
                    <p class="precio">₡<?php echo $producto->price; ?></p>
                </div>
            </div> <!--.anuncio-->
        <?php } ?>
    </div>
    <a href="productos" class="ver-todos">
        <img src="/images/plus.png" alt="Plus Symbol" class="plus-symbol">
        <span>Ver Todos</span>
    </a>
</div>