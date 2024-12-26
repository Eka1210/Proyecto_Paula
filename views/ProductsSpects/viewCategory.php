<?php
    include_once __DIR__ . "/../templates/alerts.php";
?>

<div class="detalle">   
    <h1 class="section__heading"><span>Editar Categoría</span></h1>
    <?php if(!empty($categorias)){ ?>
            <table class="table">
                <thead class="table__thead">
                    <tr>
                        <th scope="col" class="table__th">Categoría</th>
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
                                <a href="/editar/categoria?id=<?php echo $categoria->nombre;?>" class="categoryCard__view">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    Editar Categoría
                                </a>
                            </td>
                        </tr>
                        
                    <?php }?>
                </tbody>
            </table>
    <?php } else { ?>
        <p class="admins__empty">No hay categorías</p>
    <?php } ?>
</div>

