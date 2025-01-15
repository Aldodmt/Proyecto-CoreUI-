<?php
session_start();
$session_id = session_id();
if (isset($_POST['id'])) {
    $id = $_POST['id'];
}

require_once '../config/database.php';

if (!empty($id)) {
    $insert_tmp = mysqli_query($mysqli, "INSERT INTO tmp_compra (id_orden_comp ,session_id) VALUES ('$id', '$session_id')");
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $delete = mysqli_query($mysqli, "DELETE FROM tmp_compra WHERE id_tmp = '" . $id . "'");
}

?>
<table class="table table-striped table-hover align-middle">
    <thead class="table-primary">
        <tr>
            <th class="text-center">ID</th>
            <th class="text-center">ID presupuesto</th>
            <th class="text-center">Usuario</th>
            <th class="text-center">Fecha</th>
            <th class="text-center">Hora</th>
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
        $sql = mysqli_query($mysqli, "SELECT * FROM v_orden_comp, tmp_compra WHERE v_orden_comp.id_orden_comp = tmp_compra.id_orden_comp and tmp_compra.session_id = '" . $session_id . "'");
        while ($data = mysqli_fetch_array($sql)) {
            $id_tmp = $data['id_tmp'];
            $cod = $data['id_orden_comp'];
            $cod_p = $data['id_presupuesto'];
            $usuario = $data['name_user'];
            $fecha = $data['fecha'];
            $hora = $data['hora'];
            $prod = $data['p_descrip'];
            $cantidad = $data['cantidad_aprobada'];
            $precio = $data['precio_unit'];
            $total = ($data['cantidad_aprobada'] * $data['precio_unit']);
            $estado = $data['estado'];
            ?>
            <tr>
                <td><?php echo $cod; ?></td>
                <td><?php echo $cod_p; ?></td>
                <td><?php echo $usuario; ?></td>
                <td><?php echo $fecha; ?></td>
                <td><?php echo $hora; ?></td>
                <td><?php echo $prod; ?></td>
                <td><?php echo $cantidad; ?></td>
                <td><?php echo $precio; ?></td>
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