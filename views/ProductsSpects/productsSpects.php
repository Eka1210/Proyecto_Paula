<div class="prodpage">
    <div class="product-customization">
        <div class="product-image">
            <img src="<?= htmlspecialchars($producto->imagen); ?>" alt="Imagen del Producto">
        </div>
        <button data-product-id="<?php echo htmlspecialchars($producto->id); ?>">
            <?php if ($producto->liked === true): ?>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="heart">
                    <path fill="#ff0000" d="M47.6 300.4L228.3 469.1c7.5 7 17.4 10.9 27.7 10.9s20.2-3.9 27.7-10.9L464.4 300.4c30.4-28.3 47.6-68 47.6-109.5v-5.8c0-69.9-50.5-129.5-119.4-141C347 36.5 300.6 51.4 268 84L256 96 244 84c-32.6-32.6-79-47.5-124.6-39.9C50.5 55.6 0 115.2 0 185.1v5.8c0 41.5 17.2 81.2 47.6 109.5z" />
                </svg>
            <?php else: ?>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="heart">
                    <path d="M225.8 468.2l-2.5-2.3L48.1 303.2C17.4 274.7 0 234.7 0 192.8l0-3.3c0-70.4 50-130.8 119.2-144C158.6 37.9 198.9 47 231 69.6c9 6.4 17.4 13.8 25 22.3c4.2-4.8 8.7-9.2 13.5-13.3c3.7-3.2 7.5-6.2 11.5-9c0 0 0 0 0 0C313.1 47 353.4 37.9 392.8 45.4C462 58.6 512 119.1 512 189.5l0 3.3c0 41.9-17.4 81.9-48.1 110.4L288.7 465.9l-2.5 2.3c-8.2 7.6-19 11.9-30.2 11.9s-22-4.2-30.2-11.9zM239.1 145c-.4-.3-.7-.7-1-1.1l-17.8-20-.1-.1s0 0 0 0c-23.1-25.9-58-37.7-92-31.2C81.6 101.5 48 142.1 48 189.5l0 3.3c0 28.5 11.9 55.8 32.8 75.2L256 430.7 431.2 268c20.9-19.4 32.8-46.7 32.8-75.2l0-3.3c0-47.3-33.6-88-80.1-96.9c-34-6.5-69 5.4-92 31.2c0 0 0 0-.1 .1s0 0-.1 .1l-17.8 20c-.3 .4-.7 .7-1 1.1c-4.5 4.5-10.6 7-16.9 7s-12.4-2.5-16.9-7z" />
                </svg>
            <?php endif; ?>
        </button>

        <!-- Opciones de personalización -->
        <div class="customization-options">
            <h1 class="section__heading"><span>Personaliza <?php echo $producto->name; ?> </span></h1>
            <form method="POST">
                <?php foreach ($options as $option): ?>
                    <div class="customization-option">
                        <h2><?= htmlspecialchars($option->name); ?></h2>
                        <select name="options[<?= $option->optionID; ?>]" required>
                            <option value="" disabled selected>Seleccionar...</option>
                            <?php foreach ($option->decodedValues as $value): ?>
                                <option value="<?= htmlspecialchars($value); ?>"><?= htmlspecialchars($value); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endforeach; ?>

                <!-- Selección de cantidad -->
                <div class="quantity-selection">
                    <p class="display-description">Descripción: <?php echo htmlspecialchars($producto->description); ?></p>
                    <?php
                    if ($producto->discountPercentage > 0) {
                        $discountedPrice = $producto->price - ($producto->price * $producto->discountPercentage / 100);
                    ?>
                        <p class="display-price" style="color: green;">₡<?php echo number_format($discountedPrice, 2); ?> I.V.A.I</p>
                        <p class="display-price" style="text-decoration: line-through; font-size: 1em;">₡<?php echo number_format($producto->price, 2); ?></p>
                    <?php
                    } else {
                    ?>
                        <p class="display-price">₡<?php echo number_format($producto->price, 2); ?> I.V.A.I</p>
                    <?php
                    }
                    ?>
                    <h2>Cantidad</h2>
                    <input type="number" name="quantity" min="1" value="1" required>
                </div>

                <!-- Botón para agregar al carrito -->
                <button type="submit" class="customization-form__submit">Agregar al Carrito</button>

            </form>
        </div>
    </div>

    <div class="recomendations">
        <h2>Recomendados</h2>
        <div class="products-list">
            <?php foreach ($recomendados as $producto) { ?>
                <div class="product">
                    <div>
                        <a href="/mostrarproducto?nombre=<?php echo $producto->name; ?>">
                            <div class="product-image">
                                <img src="<?php echo htmlspecialchars($producto->imagen); ?>" alt="Imagen del Anuncio" style="display: block; margin: 0 auto;">
                            </div>
                        </a>

                    </div>

                    <div class="contenido-anuncio">
                        <p> <?php echo $producto->name; ?> </p>
                        <div style="justify-content: flex-start;">
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

                        </div>

                    </div>
                </div>
            <?php } ?>

        </div>

    </div>


    <div class="comments">
        <div class="comment-section">
            <h2>Comentarios</h2>
            <!-- Comment Form -->
            <form class="comment-form">
                <textarea placeholder="Escribe tu comentario..."></textarea>
                <div class="rating">
                    <span>Tu calificación:</span>
                    <div class="stars">
                        <input type="radio" id="star5" name="rating" value="5">
                        <label for="star5">★</label>
                        <input type="radio" id="star4" name="rating" value="4">
                        <label for="star4">★</label>
                        <input type="radio" id="star3" name="rating" value="3">
                        <label for="star3">★</label>
                        <input type="radio" id="star2" name="rating" value="2">
                        <label for="star2">★</label>
                        <input type="radio" id="star1" name="rating" value="1">
                        <label for="star1">★</label>
                    </div>
                </div>
                <button class="button" type="submit">Publicar Comentario</button>
            </form>

            <!-- Static Comments -->
            <div class="comments-container">
                <!-- Comment 1 -->
                <div class="comment">
                    <div class="comment-header">
                        <span class="user-name">Maria García</span>
                        <div class="rating-display">
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                            <span class="star">★</span>
                        </div>
                        <span class="date">20/01/2025</span>
                    </div>
                    <div class="comment-text">
                        Excelente libro de historia, muy detallado y bien investigado.
                    </div>
                </div>

                <!-- Comment 2 -->
                <div class="comment">
                    <div class="comment-header">
                        <span class="user-name">Carlos Rodríguez</span>
                        <div class="rating-display">
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                            <span class="star filled">★</span>
                        </div>
                        <span class="date">19/01/2025</span>
                    </div>
                    <div class="comment-text">
                        La narrativa es fascinante, no podía dejar de leerlo.
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>




<script>
    const isLoggedIn = <?php echo isset($_SESSION['userId']) ? 'true' : 'false'; ?>;

    const heartIcon = `
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="heart">
            <path fill="#ff0000" d="M47.6 300.4L228.3 469.1c7.5 7 17.4 10.9 27.7 10.9s20.2-3.9 27.7-10.9L464.4 300.4c30.4-28.3 47.6-68 47.6-109.5v-5.8c0-69.9-50.5-129.5-119.4-141C347 36.5 300.6 51.4 268 84L256 96 244 84c-32.6-32.6-79-47.5-124.6-39.9C50.5 55.6 0 115.2 0 185.1v5.8c0 41.5 17.2 81.2 47.6 109.5z"/>
        </svg>`;

    const emptyHeartIcon = `
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="heart">
            <path d="M225.8 468.2l-2.5-2.3L48.1 303.2C17.4 274.7 0 234.7 0 192.8l0-3.3c0-70.4 50-130.8 119.2-144C158.6 37.9 198.9 47 231 69.6c9 6.4 17.4 13.8 25 22.3c4.2-4.8 8.7-9.2 13.5-13.3c3.7-3.2 7.5-6.2 11.5-9c0 0 0 0 0 0C313.1 47 353.4 37.9 392.8 45.4C462 58.6 512 119.1 512 189.5l0 3.3c0 41.9-17.4 81.9-48.1 110.4L288.7 465.9l-2.5 2.3c-8.2 7.6-19 11.9-30.2 11.9s-22-4.2-30.2-11.9zM239.1 145c-.4-.3-.7-.7-1-1.1l-17.8-20-.1-.1s0 0 0 0c-23.1-25.9-58-37.7-92-31.2C81.6 101.5 48 142.1 48 189.5l0 3.3c0 28.5 11.9 55.8 32.8 75.2L256 430.7 431.2 268c20.9-19.4 32.8-46.7 32.8-75.2l0-3.3c0-47.3-33.6-88-80.1-96.9c-34-6.5-69 5.4-92 31.2c0 0 0 0-.1 .1s0 0-.1 .1l-17.8 20c-.3 .4-.7 .7-1 1.1c-4.5 4.5-10.6 7-16.9 7s-12.4-2.5-16.9-7z" />
                                </svg>`;

    const heartContainers = document.querySelectorAll('.display-heart');

    heartContainers.forEach(container => {
        const productId = container.dataset.productId;

        container.addEventListener('click', function() {
            if (!isLoggedIn) {
                console.log('User not logged in. Action not allowed.');
                return;
            }

            let xhr = new XMLHttpRequest();
            xhr.open("GET", `http://localhost:3000/like?productLiked=${productId}`, true);

            xhr.onload = () => {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        const currentHeart = this.innerHTML;
                        if (currentHeart.includes('fill="#ff0000"')) {
                            this.innerHTML = emptyHeartIcon;
                        } else {
                            this.innerHTML = heartIcon;
                        }
                        this.classList.toggle("active");
                    }
                }
            };

            xhr.send();
        });
    });
</script>