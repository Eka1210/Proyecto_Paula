<div style="text-align: right; margin-right: 20px;">
    <a href="/admin/opcion/crear?id=<?php echo $producto->id; ?>" class="form__submit--orange" style="display: inline-block;">
        Crear Opcion
    </a>
</div>

<div class="detalle">   
    <h1 class="section__heading"><span> Opciones Personalizadas de <?php echo $producto->name; ?> </span></h1>
    <?php if(!empty($opcionesProducto)){ ?>
        <table class="table">
                <thead class="table__thead">
                    <tr>
                        <th scope="col" class="table__th">Opciones</th>
                        <th scope="col" class="table__th"></th>
                        <th scope="col" class="table__th"></th>
                        <th scope="col" class="table__th"></th>
                    </tr>
                </thead>
                <tbody class="table__tbody">
                    <?php foreach($opcionesProducto as $opciones){?>
                        <tr class="table__tr">
                            <td class="table__td">
                                <?php echo $opciones->name; ?>
                            </td>
                            <td class="table__td">
                                <a href="/editar/option?id=<?php echo $opciones->id;?>" class="categoryCard__view">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    Editar
                                </a>
                            </td>
                            <td class="table__td">
                                <form action="/eliminar/option" method="POST" onsubmit="return confirm('Está seguro que quiere eliminar el producto?')">
                                    <input type="hidden" name="id" value="<?php echo $opciones->id; ?>">
                                    <button type="submit" class="categoryCard__view">
                                        <i class="fa-solid fa-trash"></i>
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                        
                    <?php }?>
                </tbody>
            </table>
    <?php } else { ?>
        <p class="admins__empty">No hay Opciones Personalizables</p>
    <?php } ?>
</div>
    
