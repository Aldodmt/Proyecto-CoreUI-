<?php
session_start();
$session_id = session_id();
require_once '../../config/database.php';

if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
    echo "<meta http-equiv='refresh' content='0; url=index.php?alert=3'>";
    exit;
}

if ($_GET['act'] == 'insert') {
    if (isset($_POST['Guardar'])) {
        $mysqli->begin_transaction();

        // Recibir datos del formulario
        $codigo = $_POST['codigo'];
        $tipo = $_POST['tipo'];
        $razon = $_POST['razon'];
        $fecha = $_POST['fecha'];

        $query_nota = mysqli_query($mysqli, "SELECT * FROM v_compras, tmp_nota where v_compras.cod_compra = tmp_nota.cod_compra");
        $datos = mysqli_fetch_array($query_nota);
        $cod_prod = $datos['cod_producto'];
        $cod_depo = $datos['cod_deposito'];
        $precio_unit = $datos['precio'];

        $cantidad_ajustar = $_POST['cantidad_ajustar'] ?? 0; // Usa 0 si el valor no se envía
        $estado = 'activo';
        $usuario = $_SESSION['id_user'];

        // Obtener codigos
        $sql_c = mysqli_query($mysqli, "SELECT * FROM v_compras, tmp_nota WHERE v_compras.cod_compra = tmp_nota.cod_compra");
        $data_2 = mysqli_fetch_array($sql_c);
        $cod_compra = $data_2['cod_compra'];
        $codigo_proveedor = $data_2['cod_proveedor'];

        // Validar stock solo si el tipo es crédito
        if ($tipo === "credito") {
            $queryStock = $mysqli->prepare("SELECT cantidad FROM stock WHERE cod_producto = ? AND cod_deposito = ?");
            $queryStock->bind_param("ii", $cod_prod, $cod_depo);
            $queryStock->execute();
            $resultStock = $queryStock->get_result();
            $stockActual = $resultStock->fetch_assoc()['cantidad'];

            if ($cantidad_ajustar > $stockActual) {
                throw new Exception("El monto a ajustar excede el stock disponible.");
            }
        }

        $monto = ($cantidad_ajustar * $precio_unit);


        // Insertar detalle de nota
        $stmt = $mysqli->prepare("INSERT INTO det_nota_credit_debit (id_nota, cod_proveedor, monto, razon, cod_producto, cod_deposito, cantidad) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iiisiii", $codigo, $codigo_proveedor, $monto, $razon, $cod_prod, $cod_depo, $cantidad_ajustar);
        $stmt->execute();

        // Actualizar cuentas por pagar
        if ($tipo === "credito") {
            $stmt4 = $mysqli->prepare("UPDATE v_cuentas SET monto_total = monto_total - ? WHERE cod_compra = ?");
        } elseif ($tipo === "debito") {
            $stmt4 = $mysqli->prepare("UPDATE v_cuentas SET monto_total = monto_total + ? WHERE cod_compra = ?");
        }
        $stmt4->bind_param("di", $monto, $cod_compra);
        $stmt4->execute();

        // Actualizar stock
        if ($tipo === "credito") {
            $stmtStock = $mysqli->prepare("UPDATE stock SET cantidad = cantidad - ? WHERE cod_producto = ? AND cod_deposito = ?");
        } elseif ($tipo === "debito") {
            $stmtStock = $mysqli->prepare("UPDATE stock SET cantidad = cantidad + ? WHERE cod_producto = ? AND cod_deposito = ?");
        }
        $stmtStock->bind_param("iii", $cantidad_ajustar, $cod_prod, $cod_depo);
        $stmtStock->execute();

        // Insertar cabecera de nota
        $stmt5 = $mysqli->prepare("INSERT INTO nota_credito_debito (id_nota, tipo, fecha_emision, estado, cod_compra, id_user) 
                                        VALUES (?, ?, ?, ?, ?, ?)");
        $stmt5->bind_param("isssii", $codigo, $tipo, $fecha, $estado, $cod_compra, $usuario);
        $stmt5->execute();

        $mysqli->commit();

        if ($stmt5) {
            header("Location: ../../main.php?module=nota&alert=4");
        } else {
            header("Location: ../../main.php?module=nota&alert=2");
        }
    }
} elseif ($_GET['act'] == 'anular') {
    if (isset($_GET['id_nota'])) {
        $codigo = $_GET['id_nota'];
        $mysqli->begin_transaction();

        try {
            // Obtener detalles de la nota
            $result = $mysqli->query("SELECT estado, cod_compra, monto, tipo, cod_producto, cod_deposito FROM v_nota WHERE id_nota = $codigo");
            $row = $result->fetch_assoc();

            if ($row['estado'] === 'anulado') {
                header("Location: ../../main.php?module=nota&alert=6");
                exit;
            }

            // Anular la nota
            $stmt7 = $mysqli->prepare("UPDATE nota_credito_debito SET estado = 'anulado' WHERE id_nota = ?");
            $stmt7->bind_param("i", $codigo);
            $stmt7->execute();

            // Revertir ajustes en cuentas y stock
            $monto = $row['monto'];
            $cod_compra = $row['cod_compra'];
            $cod_prod = $row['cod_producto'];
            $cod_depo = $row['cod_deposito'];
            $tipo = $row['tipo'];

            if ($tipo === "credito") {
                $stmt9 = $mysqli->prepare("UPDATE v_cuentas SET monto_total = monto_total + ? WHERE cod_compra = ?");
                $stmtStock = $mysqli->prepare("UPDATE stock SET cantidad = cantidad + ? WHERE cod_producto = ? AND cod_deposito = ?");
            } elseif ($tipo === "debito") {
                $stmt9 = $mysqli->prepare("UPDATE v_cuentas SET monto_total = monto_total - ? WHERE cod_compra = ?");
                $stmtStock = $mysqli->prepare("UPDATE stock SET cantidad = cantidad - ? WHERE cod_producto = ? AND cod_deposito = ?");
            }

            $stmt9->bind_param("di", $monto, $cod_compra);
            $stmt9->execute();

            $stmtStock->bind_param("iii", $cantidad_ajustar, $cod_prod, $cod_depo);
            $stmtStock->execute();

            $mysqli->commit();
            header("Location: ../../main.php?module=nota&alert=1");
        } catch (Exception $e) {
            $mysqli->rollback();
            error_log("Error al anular nota: " . $e->getMessage());
            header("Location: ../../main.php?module=nota&alert=2");
        }
    }
}
?>