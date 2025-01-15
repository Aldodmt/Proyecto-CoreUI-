<?php
session_start();
$session_id = session_id();
if (isset($_POST['id'])) {
    $id = $_POST['id'];
}

require_once '../config/database.php';

if (!empty($id)) {
    $insert_tmp = mysqli_query($mysqli, "INSERT INTO tmp_nota (cod_compra ,session_id) VALUES ('$id', '$session_id')");
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $delete = mysqli_query($mysqli, "DELETE FROM tmp_nota WHERE id_tmp = '" . $id . "'");
}

?>
<table class="table table-striped table-hover align-middle">
    <thead class="table-primary">
        <tr>
            <th class="text-center">ID compra</th>
            <th class="text-center">ID orden compra</th>
            <th class="text-center">Usuario</th>
            <th class="text-center">Proveedor</th>
            <th class="text-center">Deposito</th>
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
        $sql = mysqli_query($mysqli, "SELECT * FROM v_compras, tmp_nota WHERE v_compras.cod_compra = tmp_nota.cod_compra and tmp_nota.session_id = '" . $session_id . "'");
        while ($row = mysqli_fetch_array($sql)) {
            $id_tmp = $row['id_tmp'];
            $cod = $row['cod_compra'];
            $cod_o = $row['id_orden_comp'];
            $razon = $row['razon_social'];
            $usu = $row['name_user'];
            $fecha = $row['fecha'];
            $hora = $row['hora'];
            $prod = $row['p_descrip'];
            $depo = $row['descrip'];
            $cantidad = $row['cantidad'];
            $precio = $row['precio'];
            $total = ($row['cantidad'] * $row['precio']);
            $estado = $row['estado'];
            ?>
            <tr>
                <td><?php echo $cod; ?></td>
                <td><?php echo $cod_o; ?></td>
                <td><?php echo $usu; ?></td>
                <td><?php echo $razon; ?></td>
                <td><?php echo $depo; ?></td>
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