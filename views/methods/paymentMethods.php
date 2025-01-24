<?php
    include_once __DIR__ . "/../templates/alerts.php";
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin: 0 20px;">
    <a href="/addMetodoPago" class="form__submit--orange">
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
                        <th scope="col" class="table__th"></th>
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
                                <form action="/removeMetodoPago" method="POST" onsubmit="return confirm('Está seguro que quiere eliminar este método?')">
                                    <input type="hidden" name="id" value="<?php echo $metodoPago->id; ?>">
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
        <p class="admins__empty">No hay métodos de pago</p>
    <?php } ?>
</div>

