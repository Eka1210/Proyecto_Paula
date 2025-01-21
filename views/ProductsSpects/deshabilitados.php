
<?php
    include_once __DIR__ . "/../templates/alerts.php";
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin: 0 20px;">
    <a href="/admin/productos" class="form__submit--orange">
        Gestión Productos
    </a>    
    
</div>



<div class="detalle">   
    <h1 class="section__heading"><span> Productos Deshabilitados </span></h1>
    <?php if(!empty($productos)){ ?>
            <table class="table">
                <thead class="table__thead">
                    <tr>
                        <th scope="col" class="table__th">Producto</th>
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
                            <form action="/admin/productos/activo2" method="POST">
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
        <p class="admins__empty">No hay Productos Deshabilitados</p>
    <?php } ?>
</div>

