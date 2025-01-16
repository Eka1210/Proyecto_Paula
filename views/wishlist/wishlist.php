<div>
    <h1 class="section__heading"><span> WishList </span></h1>

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
                            <img src="<?php echo htmlspecialchars($product->imagen); ?>"
                                alt="Imagen de <?php echo htmlspecialchars($product->name); ?>"
                                class="wishImage">
                        </td>
                        <td class="table__td">
                            <?php echo htmlspecialchars($product->price); ?>
                        </td>
                        <td class="table__td">
                            <form action="cart/AddToCart" method="post" style="margin-bottom: 10px;">
                                <input type="hidden" value="<?php echo htmlspecialchars($product->id); ?>" id="producto" name="producto">
                                <input type="hidden" value="<?php echo htmlspecialchars($product->price); ?>" id="price" name="price">
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
                                <button class="btn" type="submit" id="addToCartButton" data-product="<?php echo htmlspecialchars($product->id); ?>">Agregar al Carrito</button>
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