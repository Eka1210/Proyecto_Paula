<?php
    include_once __DIR__ . "/../templates/alerts.php";
?>

<div class="detalle">   
    <h1 class="section__heading"><span>Eliminar Producto</span></h1>
    <?php if(!empty($productos)){ ?>
            <table class="table">
                <thead class="table__thead">
                    <tr>
                        <th scope="col" class="table__th">Producto</th>
                        <th scope="col" class="table__th">Precio</th>
                        <th scope="col" class="table__th">Bajo Encargo</th>
                        <th scope="col" class="table__th">Cantidad</th>
                        <th scope="col" class="table__th"></th>
                    </tr>
                </thead>
                <tbody class="table__tbody">
                    <?php foreach($productos as $producto){?>
                        <tr class="table__tr">
                            <td class="table__td">
                                <?php echo $producto->name; ?>
                            </td>
                            <td class="table__td">
                                <?php echo $producto->price; ?>
                            </td>
                            <td class="table__td">
                                <?php if($producto->encargo ==1) {echo 'Sí';} else{echo 'No';}; ?>
                            </td>
                            <td class="table__td">
                                <?php if($producto->encargo ==1) {echo 'No Aplica';} else{echo $producto->cantidad;};?>
                            </td>
                            <td class="table__td">
                                <form action="/admin/productos" method="POST" onsubmit="return confirm('Está seguro que quiere eliminar el producto?')">
                                    <input type="hidden" name="id" value="<?php echo $producto->id; ?>">
                                    <button type="submit" class="categoryCard__view">
                                        <i class="fa-solid fa-trash"></i>
                                        Eliminar Producto
                                    </button>
                                </form>
                            </td>

                        </tr>
                        
                    <?php }?>
                </tbody>
            </table>
    <?php } else { ?>
        <p class="admins__empty">No hay Productos</p>
    <?php } ?>
</div>

