<div>
    <h1 class="section__heading"><span> Lista de favoritos </span></h1>

    <?php if (!empty($productList)) { ?>

        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Nombre</th>
                    <th scope="col" class="table__th">Imagen</th>
                    <th scope="col" class="table__th">Precio</th>
                    <th scope="col" class="table__th"></th>

                </tr>
            </thead>
            <tbody class="table__tbody">
                <?php foreach ($productList as $product) { ?>

                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo htmlspecialchars($product->name); ?>
                        </td>
                        <td class="table__td">
                            <a href="/mostrarproducto?nombre=<?php echo $product->name; ?>">
                                <div class="product-image">
                                    <img src="<?php echo htmlspecialchars($product->imagen); ?>"
                                        alt="Imagen de <?php echo htmlspecialchars($product->name); ?>"
                                        class="wishImage">
                                </div>
                            </a>
                        </td>
                        <td class="table__td">

                            <?php
                            if ($product->discountPercentage > 0) {
                                $discountedPrice = $product->price - ($product->price * $product->discountPercentage / 100);
                            ?>
                                <p style="color: green;">₡<?php echo number_format($discountedPrice, 2); ?></p>
                                <p style="text-decoration: line-through; font-size: 1em;">₡<?php echo number_format($product->price, 2); ?></p>
                            <?php
                            } else {
                            ?>
                                <p>₡<?php echo number_format($product->price, 2); ?> </p>
                            <?php
                            }
                            ?>
                        </td>
                        <td class="table__td">
                            <form action="/wishlist/eliminar" method="post" onsubmit="return confirm('Está seguro que quiere eliminar el producto de la lista de favoritos?')">
                                <input type="hidden" value="<?php echo htmlspecialchars($product->id); ?>" id="producto" name="producto">
                                <button style="background-color: red;" class="btn" type="submit" id="removeFromWishlistButton" data-product="<?php echo htmlspecialchars($product->id); ?>">Eliminar de la lista</button>
                            </form>



                        </td>


                    </tr>
                <?php } ?>
            </tbody>
        </table>

    <?php } else { ?>
        <p class="admins__empty">No hay productos en la lista</p>
    <?php } ?>
</div>