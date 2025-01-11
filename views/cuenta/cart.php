<?php
    if($result){
        $message = showNotification(intval($result));
        if($message) { ?>
            <p class='alert success'> <?php echo s($message) ?> </p>;
        <?php }
    }
    if($error){
        $error = showErrors(intval($error));
        if($error) {?>
            <p class='alert error'> <?php echo s($error) ?> </p>;
        <?php }
    }
?>

<h1>Carrito</h1>

<table class="products cart">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Imagen</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Categoría</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($productos as $producto){?>
            <tr>
                <td><?php echo $producto->name ?></td>
                <td><img src="/images/<?php echo $producto->imagen ?>" alt="Table Image" class="table-image"></td>
                <td>₡<?php echo $producto->price ?></td>
                <td> <?php echo $producto->cantidad ?> </td>
                <td>
                    <?php foreach($categorias as $categoria){
                        if($producto->categoryID === $categoria->id){
                            echo $categoria->tipo;
                        }
                    } ?>
                </td>
                <td>
                    <form method="POST" class="w-100" action="carrito">
                        <input type="hidden" name="id" value="<?php echo $producto->id ?>">
                        <input type="hidden" name="type" value="quitar">
                        <input type="submit" class="icon-delete" value="&#128465;">
                    </form>
                </td>
            </tr>

        <?php } ?>
    </tbody>
</table>

<div class="info-carrito">
    <p>Cantidad de productos: <span>
        <?php 
            $cantidad = 0;
            foreach($productos as $producto){
                $cantidad += $producto->cantidad;
            }
            echo $cantidad;
        ?>
    </span></p>
    <p class="total">Total: <span>
        <?php 
            $total = 0;
            foreach($productos as $producto){
                $total += $producto->price;
            }
            echo '₡' . $total;
        ?>
    </span></p>

    <form method="POST">
        <input type="hidden" name="type" value="enviar">
        <input type="submit" class="send-cart" value="Enviar Pedido">
    </form>

</div>