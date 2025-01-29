<?php
    include_once __DIR__ . "/../templates/alerts.php";
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin: 0 20px;">
    <a href="/admin/addMetodoEntrega" class="form__submit--orange">
        Crear Método de Entrega
    </a>
</div>

<div class="detalle">   
    <h1 class="section__heading"><span> Gestión de Métodos de Entrega </span></h1>
    <?php if(!empty($metodosEntrega)){ ?>
            <table class="table">
                <thead class="table__thead">
                    <tr>
                        <th scope="col" class="table__th">Método de Entrega</th>
                        <th scope="col" class="table__th">Descripción</th>
                        <th scope="col" class="table__th">Costo</th>
                        <th scope="col" class="table__th"></th>
                        <th scope="col" class="table__th">Activo</th>
                    </tr>
                </thead>
                <tbody class="table__tbody">
                    <?php foreach($metodosEntrega as $metodoEntrega){?>
                        <tr class="table__tr">
                            <td class="table__td">
                                <?php echo $metodoEntrega->name; ?>
                            </td>
                            <td class="table__td">
                                <?php echo $metodoEntrega->description; ?>
                            </td>
                            <td class="table__td">
                                <?php echo $metodoEntrega->cost; ?>
                            </td>
                            <td class="table__td">
                                <a href="/admin/editMetodoEntrega?id=<?php echo $metodoEntrega->name;?>" class="categoryCard__view">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    Editar
                                </a>
                            </td>
                            <td class="table__td">
                            <form action="/admin/metodosEntrega/activo" method="POST">
                                <input type="hidden" name="id" value="<?php echo $metodoEntrega->id; ?>">
                                <input type="hidden" name="activo" value="<?php echo $metodoEntrega->active ? 0 : 1; ?>">
                                <button type="submit" class="categoryCard__view">
                                    <i class="fa-solid <?php echo $metodoEntrega->active ? 'fa-toggle-on' : 'fa-toggle-off'; ?>"></i>
                                    <?php echo $metodoEntrega->active ? 'Deshabilitar' : 'Habilitar'; ?>
                                </button>
                            </form>
                            </td>
                        </tr>
                        
                    <?php }?>
                </tbody>
            </table>
    <?php } else { ?>
        <p class="admins__empty">No hay métodos de Entrega</p>
    <?php } ?>
</div>

<div style="display: flex; justify-content: right; align-items: center; margin: 20px 20px;">
    <a href="/admin/metodosEntrega/deshabilitados" class="form__submit--orange">
        Métodos de Entrega deshabilitados
    </a>
    
</div>

