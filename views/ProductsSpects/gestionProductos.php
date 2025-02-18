
<?php
    include_once __DIR__ . "/../templates/alerts.php";
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin: 0 20px;">
    <a href="/admin/imagenes" class="form__submit--orange">
        Gestión Imágenes
    </a>    
    <a href="/admin/productos/crear" class="form__submit--orange">
        Crear Producto
    </a>
    
</div>



<div class="detalle">   
    <h1 class="section__heading"><span> Gestión de Productos </span></h1>
    <?php if(!empty($productos)){ ?>
            <table class="table">
                <thead class="table__thead">
                    <tr>
                        <th scope="col" class="table__th">Producto</th>
                        <th scope="col" class="table__th"></th>
                        <th scope="col" class="table__th"></th>
                        <th scope="col" class="table__th">Activo</th>
                    </tr>
                </thead>
                <tbody class="table__tbody">
                    <?php foreach($productos as $producto){?>
                        <tr class="table__tr">
                            <td class="table__td">
                                <?php echo $producto->name; ?>
                            </td>
                            <td class="table__td">
                                <?php if($producto->encargo == 1) { ?>
                                    <a href="/admin/personalizacion/producto?id=<?php echo $producto->id;?>" class="categoryCard__view">
                                        <i class="fa-solid fa-cogs"></i> 
                                        Gestión de Personalización
                                <?php } else { echo '&nbsp;'; } ?>
                            </td>
                            <td class="table__td">
                                <a href="/admin/editar/producto?id=<?php echo $producto->name;?>" class="categoryCard__view">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    Editar
                                </a>
                            </td>
                            <td class="table__td">
                            <form action="/admin/productos/activo" method="POST">
                                <input type="hidden" name="id" value="<?php echo $producto->id; ?>">
                                <input type="hidden" name="activo" value="<?php echo $producto->activo ? 0 : 1; ?>">
                                <button type="submit" class="categoryCard__view">
                                    <i class="fa-solid <?php echo $producto->activo ? 'fa-toggle-on' : 'fa-toggle-off'; ?>"></i>
                                    <?php echo $producto->activo ? 'Deshabilitar' : 'Habilitar'; ?>
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

<div style="display: flex; justify-content: right; align-items: center; margin: 20px 20px;">
    <a href="/admin/productos/deshabilitados" class="form__submit--orange">
        Productos deshabilitados
    </a>
    
</div>
