<?php
include_once __DIR__ . "/../templates/alerts.php";
?>

<div style="text-align: right; margin-right: 20px;">
    <a href="/admin/promocion/crear" class="form__submit--orange" style="display: inline-block;">
        Crear Promociones
    </a>
</div>

<div class="detalle">
    <h1 class="section__heading"><span> Gestión de Promociones </span></h1>
    <?php if (!empty($promociones)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Promociones</th>
                    <th scope="col" class="table__th"></th>
                    <th scope="col" class="table__th"></th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>
            <tbody class="table__tbody">
                <?php foreach ($promociones as $promocion) { ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $promocion->name; ?>
                        </td>
                        <td class="table__td">
                            <a href="/admin/editar/promocion?id=<?php echo $promocion->id; ?>" class="categoryCard__view">
                                <i class="fa-solid fa-pen-to-square"></i>
                                Editar Promoción
                            </a>
                        </td>
                        <td class="table__td">
                            <form action="/admin/promocion/eliminar" method="POST" onsubmit="return confirm('Está seguro que quiere eliminar la promoción?')">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($promocion->id);  ?>">
                                <button type="submit" class="categoryCard__view">
                                    <i class="fa-solid fa-trash"></i>
                                    Eliminar Promoción
                                </button>
                            </form>
                        </td>
                    </tr>

                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="admins__empty">No hay Promociones</p>
    <?php } ?>
</div>