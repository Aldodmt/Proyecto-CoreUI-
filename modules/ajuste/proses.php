<?php
session_start();
require_once '../../config/database.php';

if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
    echo "<meta http-equiv='refresh' content='0; url=index.php?alert=alert=3'>";
} else {
    if ($_GET['act'] == 'insert') {
        if (isset($_POST['Guardar'])) {
            $codigo = $_POST['codigo'];
            //$codigo_deposito = $_POST['codigo_deposito'];
            $fecha = $_POST['fecha'];
            $producto = $_POST['codigo_producto'];
            $depo = $_POST['codigo_deposito'];

            //query para llamar elementos de la vista de stock
            $sql = mysqli_query($mysqli, "SELECT * FROM v_stock, tmp where v_stock.cod_producto = $producto and v_stock.cod_deposito = $depo and tmp.id_producto");
            $data = mysqli_fetch_array($sql);

            $cantidad_aj = $data['cantidad_tmp'];
            $cantidad_an = $data['cantidad'];
            $user = $_SESSION['id_user'];

            // Insertar los productos en la tabla `detalle_compra`
            $stmt = $mysqli->prepare("INSERT INTO det_ajuste (id_ajuste, cod_producto, id_user, cantidad_ajustada, cantidad_anterior, cod_deposito) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iiiiii", $codigo, $producto, $user, $cantidad_aj, $cantidad_an, $depo);
            $stmt->execute();
            $stmt->close();

            // Insertar stock
            $query = $mysqli->prepare("SELECT * FROM stock WHERE cod_producto = ? and cod_deposito = ?");
            $query->bind_param("ii", $producto, $depo);
            $query->execute();
            $result = $query->get_result();
            if ($result) {
                // Actualizar stock
                $stmt4 = $mysqli->prepare("UPDATE stock SET cantidad = cantidad - ? WHERE cod_producto = ? AND cod_deposito = ?");
                $stmt4->bind_param("iii", $cantidad_aj, $producto, $depo);
                $stmt4->execute();
                $stmt4->close();
            }

            $sql = mysqli_query($mysqli, "SELECT * FROM v_ajuste, tmp WHERE v_ajuste.cod_producto = tmp.id_producto");
            $data = mysqli_fetch_array($sql);
            // Insertar cabecera de ajuste
            // Definir valores
            $id_orden = $data['id_ajuste'];
            //$codigo_proveedor = $_POST['codigo_proveedor'];
            $fecha = $_POST['fecha'];
            //$hora = $_POST['hora'];
            //$nro_factura = $_POST['nro_factura'];
            $estado = 'activo';
            $usuario = $_SESSION['id_user'];
            $motivo = $_POST['motivo'];

            // Insertar en `compra`
            $query = mysqli_query($mysqli, "INSERT INTO ajuste_inventario (id_ajuste, fecha_ajuste, motivo, estado) 
                VALUES ($codigo, '$fecha', '$motivo', '$estado')")
                or die("Error" . mysqli_error($mysqli));
            if ($query) {
                header("Location: ../../main.php?module=ajuste&alert=3");
            } else {
                header("Location: ../../main.php?module=ajuste&alert=2");
            }
        }
    } elseif ($_GET['act'] == 'anular') {
        if (isset($_GET['id_ajuste'])) {
            $codigo = $_GET['id_ajuste'];

            $result = mysqli_query($mysqli, "SELECT estado FROM ajuste_inventario WHERE id_ajuste = $codigo");
            $row = mysqli_fetch_assoc($result);

            if ($row['estado'] === 'anulado') {
                header("Location: ../../main.php?module=ajuste&alert=6");
            } else {
                // Anular cabecera de compra (cambiar estado a anulado)
                $stmt7 = $mysqli->prepare("UPDATE ajuste_inventario SET estado = 'anulado' WHERE id_ajuste = ?");
                $stmt7->bind_param("i", $codigo);
                $stmt7->execute();
                $stmt7->close();

                // Consultar detalle de compra
                $stmt8 = $mysqli->prepare("SELECT * FROM det_ajuste WHERE id_ajuste = ?");
                $stmt8->bind_param("i", $codigo);
                $stmt8->execute();
                $result2 = $stmt8->get_result();
                while ($row = $result2->fetch_assoc()) {
                    $codigo_producto = $row['cod_producto'];
                    $cod_deposito = $row['cod_deposito'];
                    $cantidad = $row['cantidad_ajustada'];

                    // Actualizar stock (restando la cantidad)
                    $stmt9 = $mysqli->prepare("UPDATE stock SET cantidad = cantidad + ? WHERE cod_producto = ? and cod_deposito = ?");
                    $stmt9->bind_param("iii", $cantidad, $codigo_producto, $cod_deposito);
                    $stmt9->execute();
                    $stmt9->close();

                    $stmt9 = $mysqli->prepare("UPDATE det_ajuste SET cantidad_ajustada = cantidad_ajustada - ? WHERE cod_producto = ? AND cod_deposito = ?");
                    $stmt9->bind_param("iii", $cantidad, $codigo_producto, $cod_deposito);
                    $stmt9->execute();
                    $stmt9->close();
                }

                if ($stmt7) {
                    header("Location: ../../main.php?module=ajuste&alert=1");
                } else {
                    header("Location: ../../main.php?module=ajuste&alert=2");
                }
            }
        }
    } elseif ($_GET['act'] == 'aprobar') {
        if (isset($_GET['id_ajuste'])) {
            $codigo = $_GET['id_ajuste'];
            // Verificar si el estado no es 'rechazado'
            $result = mysqli_query($mysqli, "SELECT estado FROM ajuste_inventario WHERE id_ajuste = $codigo");
            $row = mysqli_fetch_assoc($result);

            if ($row['estado'] === 'anulado') {
                header("Location: ../../main.php?module=ajuste&alert=5");
            } else {
                $query = mysqli_query($mysqli, "UPDATE ajuste_inventario SET estado = 'activo' WHERE id_ajuste= $codigo")
                    or die("Error: " . mysqli_error($mysqli));

                if ($query) {
                    header("Location: ../../main.php?module=ajuste&alert=3");
                } else {
                    header("Location: ../../main.php?module=ajuste&alert=2");
                }
            }
        }
    }
}
?>