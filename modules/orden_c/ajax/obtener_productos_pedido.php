<?php
include '../../../config/database.php';

if (isset($_POST['id_pedido'])) {
    $id_pedido = $_POST['id_pedido'];

    $query = "SELECT cod_producto, p_descrip FROM v_presu WHERE estado = 'aprobado' AND id_presupuesto = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $id_pedido);
    $stmt->execute();
    $result = $stmt->get_result();

    $productos = [];
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }

    echo json_encode($productos);
}
?>