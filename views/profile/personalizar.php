<div class="product-customization">
    <div class="product-image">
        <img src="<?= htmlspecialchars($product->imagen); ?>" alt="Imagen del Producto">
    </div>

    <!-- Opciones de personalización -->
    <div class="customization-options">
        <h1 class="section__heading"><span>Personaliza  <?php echo $product->name;?>  </span></h1>
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
                <h2>Cantidad</h2>
                <?php
                    if ($producto->encargo == 0) { ?>
                        <input type="number" name="quantity" min="1" max="<?php echo htmlspecialchars($producto->cantidad); ?>" value="1" required>
                    <?php } else{ ?>
                        <input type="number" name="quantity" min="1" value="1" required>
                    <?php } ?>
            </div>

            <!-- Botón para agregar al carrito -->
            <button type="submit" class="customization-form__submit">Agregar al Carrito</button>
        </form>
    </div>
</div>

