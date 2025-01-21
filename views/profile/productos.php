<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body data-user-logged-in="<?php echo isset($_SESSION['userId']) ? 'true' : 'false'; ?>">

    <h1 style="text-align: center;">Productos</h1>
    <div class="products-list">
        <?php if (!empty($productos)) { ?>
            <?php foreach ($productos as $producto) { ?>
                <div class="product">
                    <div class="product-image">
                        <img src="<?php echo htmlspecialchars($producto->imagen); ?>" alt="Imagen del Anuncio" style="display: block; margin: 0 auto;">
                    </div>
                    <p><?php echo htmlspecialchars($producto->name); ?></p>
                    <p class="precio">₡<?php echo htmlspecialchars($producto->price); ?> I.V.A.I</p>


                    <?php if ($producto->encargo == 1) { ?>
                        <form action="/personalizar/producto" method="get">
                            <input type="hidden" value="<?php echo htmlspecialchars($producto->id); ?>" name="id">
                            <button class="personalizar" type="submit">Personalizar</button>
                        </form>
                    <?php } else { ?>
                        <form action="cart/AddToCart" method="post" style="margin-bottom: 10px;">
                            <input type="hidden" value="<?php echo htmlspecialchars($producto->id); ?>" id="producto" name="producto">
                            <input type="hidden" value="<?php echo htmlspecialchars($producto->price); ?>" id="price" name="price">
                            <div class="quantity-selector">
                                <label for="quantity">Cantidad:</label>
                                <select id="quantity" name="quantity">
                                    <?php
                                    for ($i = 1; $i <= 100; $i++) {
                                        echo '<option value="' . htmlspecialchars($i) . '">' . htmlspecialchars($i) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <button class="cart-button" type="submit" id="addToCartButton" data-product="<?php echo htmlspecialchars($producto->id); ?>">Agregar al Carrito</button>
                        </form>

                        <button class="heart-container" data-product-id="<?php echo $producto->id; ?>">
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

                    <?php } ?>

                </div>
            <?php } ?>
        <?php } else { ?>
            <p class="admins__empty">No hay Productos</p>
        <?php } ?>
    </div>


    <script>
        const heartIcon = `
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="heart">
            <path fill="#ff0000" d="M47.6 300.4L228.3 469.1c7.5 7 17.4 10.9 27.7 10.9s20.2-3.9 27.7-10.9L464.4 300.4c30.4-28.3 47.6-68 47.6-109.5v-5.8c0-69.9-50.5-129.5-119.4-141C347 36.5 300.6 51.4 268 84L256 96 244 84c-32.6-32.6-79-47.5-124.6-39.9C50.5 55.6 0 115.2 0 185.1v5.8c0 41.5 17.2 81.2 47.6 109.5z"/>
        </svg>`;

        const emptyHeartIcon = `
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="heart">
                                    <path d="M225.8 468.2l-2.5-2.3L48.1 303.2C17.4 274.7 0 234.7 0 192.8l0-3.3c0-70.4 50-130.8 119.2-144C158.6 37.9 198.9 47 231 69.6c9 6.4 17.4 13.8 25 22.3c4.2-4.8 8.7-9.2 13.5-13.3c3.7-3.2 7.5-6.2 11.5-9c0 0 0 0 0 0C313.1 47 353.4 37.9 392.8 45.4C462 58.6 512 119.1 512 189.5l0 3.3c0 41.9-17.4 81.9-48.1 110.4L288.7 465.9l-2.5 2.3c-8.2 7.6-19 11.9-30.2 11.9s-22-4.2-30.2-11.9zM239.1 145c-.4-.3-.7-.7-1-1.1l-17.8-20-.1-.1s0 0 0 0c-23.1-25.9-58-37.7-92-31.2C81.6 101.5 48 142.1 48 189.5l0 3.3c0 28.5 11.9 55.8 32.8 75.2L256 430.7 431.2 268c20.9-19.4 32.8-46.7 32.8-75.2l0-3.3c0-47.3-33.6-88-80.1-96.9c-34-6.5-69 5.4-92 31.2c0 0 0 0-.1 .1s0 0-.1 .1l-17.8 20c-.3 .4-.7 .7-1 1.1c-4.5 4.5-10.6 7-16.9 7s-12.4-2.5-16.9-7z" />
                                </svg>`;

        const heartContainers = document.querySelectorAll('.heart-container');

        heartContainers.forEach(container => {
            const productId = container.dataset.productId;

            container.addEventListener('click', function() {
                const isLoggedIn = document.body.dataset.userLoggedIn === 'true';

                if (!isLoggedIn) {
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

</body>