
<?php
    include_once __DIR__ . "/../templates/alerts.php";
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin: 0 20px;">
    <a href="/admin/metodosEntrega" class="form__submit--orange">
        Gestión Métodos de Entrega
    </a>    
    
</div>



<div class="detalle">   
    <h1 class="section__heading"><span> Métodos de Entrega Deshabilitados </span></h1>
    <?php if(!empty($metodosEntrega)){ ?>
            <table class="table">
                <thead class="table__thead">
                    <tr>
                        <th scope="col" class="table__th">Método</th>
                        <th scope="col" class="table__th">Activo</th>
                    </tr>
                </thead>
                <tbody class="table__tbody">
                    <?php foreach($metodosEntrega as $metodo){?>
                        <tr class="table__tr">
                        <td class="table__td">
                                <?php echo $metodo->name; ?>
                            </td>
                            <td class="table__td">
                            <form action="/admin/metodosEntrega/activoD2" method="POST">
                                <input type="hidden" name="id" value="<?php echo $metodo->id; ?>">
                                <input type="hidden" name="activo" value="<?php echo $metodo->active ? 0 : 1; ?>">
                                <button type="submit" class="categoryCard__view">
                                    <i class="fa-solid <?php echo $metodo->active ? 'fa-toggle-on' : 'fa-toggle-off'; ?>"></i>
                                    <?php echo $metodo->active ? 'Deshabilitar' : 'Habilitar'; ?>
                                </button>
                            </form>
                        </td>
                        </tr>
                        
                    <?php }?>
                </tbody>
            </table>
    <?php } else { ?>
        <p class="admins__empty">No hay Métodos Deshabilitados</p>
    <?php } ?>
</div>

