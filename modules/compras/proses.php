<?php
session_start();
require_once '../../config/database.php';

if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
    echo "<meta http-equiv='refresh' content='0; url=index.php?alert=3'>";
    exit;
}



if ($_GET['act'] == 'insert' && isset($_POST['Guardar'])) {
    $codigo = $_POST['codigo'];
    $codigo_deposito = $_POST['codigo_deposito'];
    $codigo_proveedor = $_POST['codigo_proveedor'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $nro_factura = $_POST['nro_factura'];
    $nro_timbrado = $_POST['nro_timbrado'];
    $fecha_tim = $_POST['timbrado_vencimiento'];
    $usuario = $_SESSION['id_user'];

    // Validación del timbrado
    $hoy = date('Y-m-d');
    if ($fecha_tim <= $hoy) {
        echo "<script>alert('El timbrado ya ha vencido. Por favor, renueve el timbrado antes de continuar.'); window.history.back();</script>";
        exit;
    }

    //Sufrio un cambio en el examen XD
    /*$sql_fact = $mysqli->prepare("SELECT rango_fin FROM timbrado_comp where id_timbrado = ?");
    $sql_fact->bind_param("i", $timbrado);
    $sql_fact->execute();
    $result_fact = $sql_fact->get_result();
    $datos = mysqli_fetch_array($result_fact);
    $rango_fin = $datos['rango_fin'];

    if ($nro_factura >= $rango_fin) {
        header("Location: ../../main.php?module=compras&alert=4");
        exit;
    }*/

    // Validar datos requeridos
    /*if (empty($codigo) || empty($codigo_deposito) || empty($codigo_proveedor) || empty($fecha) || empty($nro_factura) || empty($codigo_tim)) {
        echo "<script>alert('Error: Faltan datos obligatorios.'); window.history.back();</script>";
        exit;
    }*/

    // Obtener productos y calcular el total
    $sql_si = mysqli_query($mysqli, "SELECT * FROM v_orden_comp, tmp_compra WHERE v_orden_comp.id_orden_comp = tmp_compra.id_orden_comp");
    $total = 0;
    while ($data = mysqli_fetch_array($sql_si)) {
        $codigo_producto = $data['cod_producto'];
        $cantidad = $data['cantidad_aprobada'];
        $precio_unit = $data['precio_unit'];
        $total += $cantidad * $precio_unit;



        // Insertar en `detalle_compra`
        $stmt = $mysqli->prepare("INSERT INTO detalle_compra (cod_producto, cod_compra, cod_deposito, precio, cantidad) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iiidi", $codigo_producto, $codigo, $codigo_deposito, $precio_unit, $cantidad);
        $stmt->execute();
        $stmt->close();

        // Actualizar stock
        $query = $mysqli->prepare("SELECT * FROM stock WHERE cod_producto = ? AND cod_deposito = ?");
        $query->bind_param("ii", $codigo_producto, $codigo_deposito);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows == 0) {
            // Insertar si no existe
            $stmt2 = $mysqli->prepare("INSERT INTO stock (cod_deposito, cod_producto, cantidad) VALUES (?, ?, ?)");
            $stmt2->bind_param("iii", $codigo_deposito, $codigo_producto, $cantidad);
            $stmt2->execute();
            $stmt2->close();
        } else {
            // Actualizar si ya existe
            $stmt3 = $mysqli->prepare("UPDATE stock SET cantidad = cantidad + ? WHERE cod_producto = ? AND cod_deposito = ?");
            $stmt3->bind_param("iii", $cantidad, $codigo_producto, $codigo_deposito);
            $stmt3->execute();
            $stmt3->close();
        }
    }

    $monto_pagar = 0;
    $saldo = $total - $monto_pagar;

    // Insertar en `det_cuenta_a_pagar`
    $stmt4 = $mysqli->prepare("INSERT INTO det_cuenta_a_pagar (id_cuenta, monto_total, monto_pagado) VALUES (?, ?, ?)");
    $stmt4->bind_param("idd", $codigo, $total, $monto_pagar);
    $stmt4->execute();
    $stmt4->close();

    // Insertar en `cuentas_a_pagar`
    $stmt5 = $mysqli->prepare("INSERT INTO cuentas_a_pagar (id_cuenta, fecha_emision, fecha_vencimiento, estado, cod_compra, cod_proveedor) VALUES (?, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 90 DAY), 'pendiente', ?, ?)");
    $stmt5->bind_param("iii", $codigo, $codigo, $codigo_proveedor);
    $stmt5->execute();
    $stmt5->close();

    $sql_orden = mysqli_query($mysqli, "SELECT * FROM v_orden_comp, tmp_compra WHERE v_orden_comp.id_orden_comp = tmp_compra.id_orden_comp");
    $data_orn = mysqli_fetch_array($sql_orden);
    $id_orden = $data_orn['id_orden_comp'];
    $estado = 'activo';

    // Insertar cabecera de compra
    $query = mysqli_query($mysqli, "INSERT INTO compra (cod_compra, cod_proveedor, nro_factura, fecha, estado, hora, id_user, id_orden_comp, nro_timbrado, timbrado_vencimiento)
        VALUES ($codigo, $codigo_proveedor, '$nro_factura', '$fecha', '$estado', '$hora', $usuario, $id_orden, $nro_timbrado, '$fecha_tim')")
        or die("Error" . mysqli_error($mysqli));

    if ($query) {
        header("Location: ../../main.php?module=compras&alert=1");
    } else {
        header("Location: ../../main.php?module=compras&alert=3");
    }

} elseif ($_GET['act'] == 'anular') {
    if (isset($_GET['cod_compra'])) {
        $codigo = $_GET['cod_compra'];

        // Anular cabecera de compra (cambiar estado a anulado)
        $stmt7 = $mysqli->prepare("UPDATE compra SET estado = 'anulado' WHERE cod_compra = ?");
        $stmt7->bind_param("i", $codigo);
        $stmt7->execute();
        $stmt7->close();

        // Consultar detalle de compra
        $stmt8 = $mysqli->prepare("SELECT * FROM detalle_compra WHERE cod_compra = ?");
        $stmt8->bind_param("i", $codigo);
        $stmt8->execute();
        $result2 = $stmt8->get_result();
        while ($row = $result2->fetch_assoc()) {
            $codigo_producto = $row['cod_producto'];
            $codigo_deposito = $row['cod_deposito'];
            $cantidad = $row['cantidad'];

            $stmt9 = $mysqli->prepare("UPDATE stock SET cantidad = cantidad - ? WHERE cod_producto = ? AND cod_deposito = ?");
            $stmt9->bind_param("iii", $cantidad, $codigo_producto, $codigo_deposito);
            $stmt9->execute();
            $stmt9->close();
        }

        if ($stmt7) {
            header("Location: ../../main.php?module=compras&alert=2");
        } else {
            header("Location: ../../main.php?module=compras&alert=3");
        }
    }
}
?>