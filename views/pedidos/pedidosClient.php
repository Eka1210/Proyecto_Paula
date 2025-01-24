<?php
    include_once __DIR__ . "/../templates/alerts.php";
?>

<div class="detalle">   
    <h1 class="section__heading"><span> Pedidos </span></h1>
    <?php if(!empty($pedidos)){ ?>
            <table class="table">
                <thead class="table__thead">
                    <tr>
                        <th scope="col" class="table__th">Pedido</th>
                        <th scope="col" class="table__th">Monto</th>
                        <th scope="col" class="table__th">Fecha</th>
                        <th scope="col" class="table__th">Cliente</th>
                        <th scope="col" class="table__th">Método de Pago</th>
                        <th scope="col" class="table__th">Información de Pago</th>
                        <th scope="col" class="table__th">Método de Entrega</th>
                        <th scope="col" class="table__th">Estado</th>
                        <th scope="col" class="table__th"></th>
                        <th scope="col" class="table__th"></th>
                    </tr>
                </thead>
                <tbody class="table__tbody">
                    <?php foreach($pedidos as $pedido){ ?>
                        <tr class="table__tr">
                            <td class="table__td">
                                <?php echo $pedido->id; ?>
                            </td>
                            <td class="table__td">
                                <?php echo $pedido->monto; ?>
                            </td>
                            <td class="table__td">
                                <?php echo $pedido->fecha; ?>
                            </td>
                            <td class="table__td">
                                <?php echo $pedido->cliente; ?>
                            </td>
                            <td class="table__td">
                                <?php echo $pedido->metodoPago; ?>
                            </td>
                            <td class="table__td">
                                <?php echo $pedido->metodoPagoDesc; ?>
                            </td>
                            <td class="table__td">
                                <?php echo $pedido->metodoEntrega; ?>
                            </td>
                            <td class="table__td">
                                <?php echo $pedido->descripcion; ?>
                            </td>
                            <td class="table__td">
                                <a href="/pedidos/verProductosPedido?id=<?php echo $pedido->id;?>" class="categoryCard__view">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    Ver Productos
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
    <?php } else { ?>
        <p class="admins__empty">No hay pedidos</p>
    <?php } ?>
</div>



