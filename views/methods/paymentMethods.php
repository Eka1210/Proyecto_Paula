<?php
    include_once __DIR__ . "/../templates/alerts.php";
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin: 0 20px;">
    <a href="/admin/addMetodoPago" class="form__submit--orange">
        Crear Método de Pago
    </a>
</div>

<div class="detalle">   
    <h1 class="section__heading"><span> Gestión de Métodos de Pago </span></h1>
    <?php if(!empty($metodosPago)){ ?>
            <table class="table">
                <thead class="table__thead">
                    <tr>
                        <th scope="col" class="table__th">Método de Pago</th>
                        <th scope="col" class="table__th">Descripción</th>
                        <th scope="col" class="table__th"></th>
                        <th scope="col" class="table__th">Activo</th>
                    </tr>
                </thead>
                <tbody class="table__tbody">
                    <?php foreach($metodosPago as $metodoPago){?>
                        <tr class="table__tr">
                            <td class="table__td">
                                <?php echo $metodoPago->name; ?>
                            </td>
                            <td class="table__td">|
                                <?php echo $metodoPago->description; ?>
                            </td>
                            <td class="table__td">
                                <a href="/admin/editMetodoPago?id=<?php echo $metodoPago->name;?>" class="categoryCard__view">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    Editar
                                </a>
                            </td>
                            <td class="table__td">
                            <form action="/admin/metodosPago/activo" method="POST">
                                <input type="hidden" name="id" value="<?php echo $metodoPago->id; ?>">
                                <input type="hidden" name="activo" value="<?php echo $metodoPago->active ? 0 : 1; ?>">
                                <button type="submit" class="categoryCard__view">
                                    <i class="fa-solid <?php echo $metodoPago->active ? 'fa-toggle-on' : 'fa-toggle-off'; ?>"></i>
                                    <?php echo $metodoPago->active ? 'Deshabilitar' : 'Habilitar'; ?>
                                </button>
                            </form>
                            </td>
                        </tr>
                        
                    <?php }?>
                </tbody>
            </table>
    <?php } else { ?>
        <p class="admins__empty">No hay métodos de pago</p>
    <?php } ?>
</div>

<div style="display: flex; justify-content: right; align-items: center; margin: 20px 20px;">
    <a href="/admin/metodosPago/deshabilitados" class="form__submit--orange">
        Métodos de Pago deshabilitados
    </a>
    
</div>
