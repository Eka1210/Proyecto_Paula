
<div style="display: flex; justify-content: space-between; align-items: center; margin: 0 15px;">
    <a href="/admin/productos/crear" class="form__submit--orange">
        Crear Producto
    </a>
    <a href="/admin/imagenes" class="form__submit--orange">
        Gestión Imágenes
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
                                <a href="/editar/producto?id=<?php echo $producto->name;?>" class="categoryCard__view">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    Editar Producto
                                </a>
                            </td>
                            <td class="table__td">
                                <form action="/admin/productos/eliminar" method="POST" onsubmit="return confirm('Está seguro que quiere eliminar el producto?')">
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

