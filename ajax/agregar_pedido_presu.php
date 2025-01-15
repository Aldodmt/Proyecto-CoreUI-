<?php
session_start();
$session_id = session_id();
if (isset($_POST['id'])) {
    $id = $_POST['id'];
}


require_once '../config/database.php';

if (!empty($id)) {
    $insert_tmp = mysqli_query($mysqli, "INSERT INTO tmp_presu (id_pedido ,session_id) VALUES ('$id', '$session_id')");
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $delete = mysqli_query($mysqli, "DELETE FROM tmp_presu WHERE id_tmp = '" . $id . "'");
}

?>
<table class="table table-striped table-hover align-middle">
    <thead class="table-primary">
        <tr>
            <th>Codigo</th>
            <th>Usuario</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Estado</th>
            <th class="text-center" style="width: 36px;">Eliminar</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = mysqli_query($mysqli, "SELECT * FROM v_pedido, tmp_presu WHERE v_pedido.id_pedido = tmp_presu.id_pedido and tmp_presu.session_id = '" . $session_id . "'");
        while ($row = mysqli_fetch_array($sql)) {
            $id_tmp = $row['id_tmp'];
            $id_pedido = $row['id_pedido'];
            $codigo_producto = $row['cod_producto'];
            $descrip_producto = $row['p_descrip'];
            $cantidad = $row['cantidad'];
            $fecha = $row['fecha'];
            $hora = $row['hora'];
            $estado = $row['estado'];

            $codigo_user = $row['id_user'];
            $sql_user = mysqli_query($mysqli, "SELECT name_user FROM usuarios WHERE id_user='$codigo_user'");
            $rw_user = mysqli_fetch_assoc($sql_user);
            $name_user = $rw_user['name_user'];
            ?>
            <tr>
                <td><?php echo $id_pedido; ?></td>
                <td><?php echo $name_user; ?></td>
                <td><?php echo $fecha; ?></td>
                <td><?php echo $hora; ?></td>
                <td><?php echo $descrip_producto; ?></td>
                <td><?php echo $cantidad; ?></td>
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