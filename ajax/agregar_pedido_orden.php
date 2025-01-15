<?php
session_start();
$session_id = session_id();
if (isset($_POST['id'])) {
    $id = $_POST['id'];
}

require_once '../config/database.php';

if (!empty($id)) {
    $insert_tmp = mysqli_query($mysqli, "INSERT INTO tmp_orden (id_presupuesto ,session_id) VALUES ('$id', '$session_id')");
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $delete = mysqli_query($mysqli, "DELETE FROM tmp_orden WHERE id_tmp = '" . $id . "'");
}

?>
<table class="table table-striped table-hover align-middle">
    <thead class="table-primary">
        <tr>
            <th class="text-center">ID presupuesto</th>
            <th class="text-center">ID pedido</th>
            <th class="text-center">Proveedor</th>
            <th class="text-center">Fecha Emitida</th>
            <th class="text-center">Fecha de Vencimiento</th>
            <th class="text-center">Producto</th>
            <th class="text-center">Cantidad</th>
            <th class="text-center">Precio Unitario</th>
            <th class="text-center">Total</th>
            <th class="text-center">Estado</th>
            <th class="text-center" style="width: 36px;">Eliminar</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = mysqli_query($mysqli, "SELECT * FROM v_presu, tmp_orden WHERE v_presu.id_presupuesto = tmp_orden.id_presupuesto and tmp_orden.session_id = '" . $session_id . "'");
        while ($row = mysqli_fetch_array($sql)) {
            $id_tmp = $row['id_tmp'];
            $id_presu = $row['id_presupuesto'];
            $id_pedido = $row['id_pedido'];
            $proveedor = $row['razon_social'];
            $fecha_e = $row['fecha_presu'];
            $fecha_v = $row['fecha_vencimiento'];
            $prod = $row['p_descrip'];
            $cantidad = $row['cantidad'];
            $precio_unit = $row['precio_unit'];
            $total = ($row['cantidad'] * $row['precio_unit']);
            $estado = $row['estado'];
            ?>
            <tr>
                <td><?php echo $id_presu; ?></td>
                <td><?php echo $id_pedido; ?></td>
                <td><?php echo $proveedor; ?></td>
                <td><?php echo $fecha_e; ?></td>
                <td><?php echo $fecha_v; ?></td>
                <td><?php echo $prod; ?></td>
                <td><?php echo $cantidad; ?></td>
                <td><?php echo $precio_unit; ?></td>
                <td><?php echo $total; ?></td>
                <td><?php echo $estado; ?></td>
                <td class="text-center">
                    <button class="btn btn-danger btn-sm" onclick="eliminar(<?php echo $id_tmp; ?>)">
                        <i class="cil-trash"></i>
                    </button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>