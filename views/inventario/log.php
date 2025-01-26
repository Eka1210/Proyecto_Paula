<div>
    <h1 class="section__heading"><span> Historial de<?php echo htmlspecialchars($product->name) ?> </span></h1>

    <?php if (!empty($logs)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Tiempo</th>
                    <th scope="col" class="table__th">Motivo</th>
                    <th scope="col" class="table__th">Cantidad Movida</th>
                    <th scope="col" class="table__th">Cantidad Vieja</th>
                    <th scope="col" class="table__th">Cantidad Nueva</th>
                    <th scope="col" class="table__th">+/-</th>




                </tr>
            </thead>
            <tbody class="table__tbody">
                <?php foreach ($logs as $log) { ?>

                    <tr class="table__tr">

                        <td class="table__td">
                            <?php echo htmlspecialchars($log->date); ?>
                        </td>
                        <td class="table__td">
                            <?php echo htmlspecialchars($log->action); ?>
                        </td>
                        <td class="table__td">
                            <?php echo htmlspecialchars($log->quantity); ?>
                        </td>
                        <td class="table__td">
                            <?php echo htmlspecialchars($log->old_value); ?>
                        </td>
                        <td class="table__td">
                            <?php echo htmlspecialchars($log->new_value); ?>
                        </td>
                        <?php if ($log->new_value > $log->old_value) { ?>
                            <td class="table__td" style="color: green;">
                                +
                            </td>
                        <?php } elseif ($log->new_value < $log->old_value) { ?>
                            <td class="table__td" style="color: red;">
                                -
                            </td>
                        <?php } ?>






                    </tr>

                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="admins__empty">No hay registros de este producto</p>
    <?php } ?>
</div>