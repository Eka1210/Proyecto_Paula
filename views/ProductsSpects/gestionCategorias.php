
<?php
    include_once __DIR__ . "/../templates/alerts.php";
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin: 0 20px;">
    <a href="/admin/imagenes" class="form__submit--orange">
        Gestión Imágenes
    </a>  
    <a href="/admin/categorias/crear" class="form__submit--orange">
        Crear Categoría
    </a>
</div>

<div class="detalle">   
    <h1 class="section__heading"><span> Gestión de Categorías </span></h1>
    <?php if(!empty($categorias)){ ?>
            <table class="table">
                <thead class="table__thead">
                    <tr>
                        <th scope="col" class="table__th">Categoría</th>
                        <th scope="col" class="table__th"></th>
                        <th scope="col" class="table__th"></th>
                        <th scope="col" class="table__th"></th>
                    </tr>
                </thead>
                <tbody class="table__tbody">
                    <?php foreach($categorias as $categoria){?>
                        <tr class="table__tr">
                            <td class="table__td">
                                <?php echo $categoria->nombre; ?>
                            </td>
                            <td class="table__td">
                                <a href="/admin/editar/categoria?id=<?php echo $categoria->nombre;?>" class="categoryCard__view">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    Editar Categoría
                                </a>
                            </td>
                            <td class="table__td">
                                <form action="/admin/categorias/eliminar" method="POST" onsubmit="return confirm('Está seguro que quiere eliminar la categoría?')">
                                    <input type="hidden" name="id" value="<?php echo $categoria->id; ?>">
                                    <button type="submit" class="categoryCard__view">
                                        <i class="fa-solid fa-trash"></i>
                                        Eliminar Categoría
                                    </button>
                                </form>
                            </td>
                        </tr>
                        
                    <?php }?>
                </tbody>
            </table>
    <?php } else { ?>
        <p class="admins__empty">No hay Categorías</p>
    <?php } ?>
</div>

