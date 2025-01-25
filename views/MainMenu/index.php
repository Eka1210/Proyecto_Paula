<div class="publicidad" style="display: flex; flex-direction: column; align-items: center;">
    <p style="color: #693334; font-size: 6rem; font-weight: bold; margin-bottom:0.5rem;">¿Qué es PJ Solutions?</p>
    <p style="color: #693334; font-size: 3rem; text-align: center; margin:2rem 10rem 0rem 10rem">Diseñamos emociones en papel.</p>
    <p style="color: #693334; font-size: 3rem; text-align: center; margin:1rem 10rem 0rem 10rem">Especialistas en tarjetas, agendas y detalles únicos para regalos inolvidables.</p>
    <p style="color: #693334; font-size: 3rem; text-align: center; margin:1rem 10rem 3rem 10rem">Personalizamos cada momento con amor y creatividad</p>
</div>



<h1 style="text-align: center;">Productos Destacados</h1>
<div class="container-info">
    <div class="products-list">
        <?php foreach ($productos as $producto) { ?>
            <?php if ($producto->activo == 1) { ?>
                <div class="product">
                    <a href="/mostrarproducto?nombre=<?php echo $producto->name; ?>">
                        <div class="product-image">
                            <img src="<?php echo htmlspecialchars($producto->imagen); ?>" alt="Imagen del Anuncio" style="display: block; margin: 0 auto;">
                        </div>
                    </a>
                    
                    <div class="contenido-anuncio">
                    <div class="product-details">
                        <p style="margin-top: 15px; margin-bottom: 15px;"> <?php echo $producto->name; ?> </p>
                        <?php
                        if ($producto->discountPercentage > 0) {
                            $discountedPrice = $producto->price - ($producto->price * $producto->discountPercentage / 100);
                        ?>
                            <p class="precio" style="color: green;">₡<?php echo number_format($discountedPrice, 2); ?> I.V.A.I</p>
                            <p class="precio" style="text-decoration: line-through; font-size: 1em; margin-bottom: 15px;">₡<?php echo number_format($producto->price, 2); ?></p>
                        <?php
                        } else {
                        ?>
                            <p class="precio"style="margin-bottom: 2rem;">₡<?php echo number_format($producto->price, 2); ?> I.V.A.I</p>
                        <?php
                        }
                        ?>
                    </div>
                    </div>
                </div> <!--.anuncio-->
            <?php } ?>
        <?php } ?>
    </div>
    <a href="productos" class="ver-todos">
        <img src="/images/plus.png" alt="Plus Symbol" class="plus-symbol">
        <span>Ver Todos</span>
    </a>
</div>