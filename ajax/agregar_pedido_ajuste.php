<?php
session_start();
$session_id = session_id();
if (isset($_POST['id'])) {
    $id = $_POST['id'];
}
if (isset($_POST['cantidad_a'])) {
    $cantidad = $_POST['cantidad_a'];
}

require_once '../config/database.php';

if (!empty($id) && !empty($cantidad)) {
    $insert_tmp = mysqli_query($mysqli, "INSERT INTO tmp (id_producto, cantidad_tmp, session_id) VALUES ('$id', '$cantidad', '$session_id')");
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $delete = mysqli_query($mysqli, "DELETE FROM tmp WHERE id_tmp = '" . $id . "'");
}

?>
<table class="table table-striped table-hover align-middle">
    <thead class="table-primary">
        <tr>
            <th>Codigo</th>
            <th>Tipo de prod.</th>
            <th>Unid. de Medida</th>
            <th>Producto</th>
            <th>Cantidad anterior</th>
            <th>Cantidad ajustada</th>
            <th>Cantidad final</th>
            <th class="text-center" style="width: 36px;">Eliminar</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = mysqli_query($mysqli, "SELECT * FROM v_stock, tmp WHERE v_Stock.cod_producto= tmp.id_producto and tmp.session_id = '" . $session_id . "'");
        while ($row = mysqli_fetch_array($sql)) {
            $id_tmp = $row['id_tmp'];
            $codigo_producto = $row['cod_producto'];
            $descrip_producto = $row['p_descrip'];
            $tipo_prod = $row['t_p_descrip'];
            $u_medida = $row['u_descrip'];
            $cantidad_aj = $row['cantidad_tmp'];
            $cantidad_an = $row['cantidad'];
            $cantidad_f = ($row['cantidad'] - $row['cantidad_tmp']);
            ?>
            <tr>
                <td><?php echo $codigo_producto; ?></td>
                <td><?php echo $tipo_prod; ?></td>
                <td><?php echo $u_medida; ?></td>
                <td><?php echo $descrip_producto; ?></td>
                <td><?php echo $cantidad_an; ?></td>
                <td><?php echo $cantidad_aj; ?></td>
                <td><?php echo $cantidad_f; ?></td>
                <td class="text-center">
                    <button class="btn btn-danger btn-sm" onclick="eliminar(<?php echo $id_tmp; ?>)">
                        <i class="cil-trash"></i>
                    </button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <input type="hidden" class="form-control" name="codigo_producto"
                value="<?php echo $codigo_producto ?? 0; ?>">
            <input type="hidden" class="form-control" name="cantidad_a" value="<?php echo $cantidad ?? 0; ?>">
        </tr>
    </tfoot>
</table>