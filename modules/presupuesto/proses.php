<?php
session_start();

require_once '../../config/database.php';

if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
    echo "<meta http-equiv='refresh' content='0; url=index.php?alert=alert=3'>";
} else {
    if ($_GET['act'] == 'insert') {
        if (isset($_POST['Guardar'])) {
            $codigo = $_POST['codigo'];

            if (!empty($_POST['productos_json'])) {
                $productos = json_decode($_POST['productos_json'], true);

                if (is_array($productos)) {
                    foreach ($productos as $producto) {
                        $codigo_producto = $producto['codigo_producto'];
                        $cantidad = $producto['cantidad'];
                        $precio_unit = $producto['precio_unitario'];

                        // Insertar los productos en la tabla `det_presu`   
                        $insert_detalle = mysqli_query($mysqli, "INSERT INTO det_presu (id_presupuesto, cod_producto, cantidad, precio_unit) 
                            VALUES ($codigo, '$codigo_producto', $cantidad, $precio_unit)")
                            or die('Error: ' . mysqli_error($mysqli));
                    }
                } else {
                    echo "<script>
                        alert('Error: Los datos de los productos no son válidos.');
                        window.history.back();
                    </script>";
                    exit;
                }
            }

            // Consulta original para obtener datos relacionados al presupuesto
            $sql_p = mysqli_query($mysqli, "SELECT * FROM v_pedido, tmp_presu WHERE v_pedido.id_pedido = tmp_presu.id_pedido");
            $data = mysqli_fetch_array($sql_p);

            // Insertar cabecera de presupuesto
            $codigo_pedido = $data['id_pedido'];
            $codigo_proveedor = $_POST['codigo_proveedor'];
            $fecha_e = $_POST['fecha_e'];
            $fecha_v = $_POST['fecha_v'];

            if (strtotime($fecha_v) <= strtotime($fecha_e)) {
                echo "<script>
                alert('Error: La fecha de vencimiento no puede ser menor que la fecha de emisión ni tampoco puede ser igual.');
                window.history.back();
              </script>";
                exit;
            }

            $estado = 'pendiente';
            $query = mysqli_query($mysqli, "INSERT INTO presupuesto (id_presupuesto, fecha_presu, fecha_vencimiento, cod_proveedor, estado, id_pedido) 
                VALUES ($codigo, '$fecha_e', '$fecha_v', $codigo_proveedor, '$estado', '$codigo_pedido')")
                or die("Error" . mysqli_error($mysqli));

            if ($query) {
                header("Location: ../../main.php?module=presupuesto&alert=1");
            } else {
                header("Location: ../../main.php?module=presupuesto&alert=3");
            }
        }
    } elseif ($_GET['act'] == 'anular') {
        if (isset($_GET['id_presupuesto'])) {
            $codigo = $_GET['id_presupuesto'];

            $result = mysqli_query($mysqli, "SELECT estado FROM presupuesto WHERE id_presupuesto = $codigo");
            $row = mysqli_fetch_assoc($result);

            if ($row['estado'] === 'rechazado') {
                header("Location: ../../main.php?module=presupuesto&alert=6");
            } else {
                $query = mysqli_query($mysqli, "UPDATE presupuesto SET estado = 'rechazado' WHERE id_presupuesto= $codigo")
                    or die("Error: " . mysqli_error($mysqli));

                if ($query) {
                    header("Location: ../../main.php?module=presupuesto&alert=2");
                } else {
                    header("Location: ../../main.php?module=presupuesto&alert=3");
                }
            }
        }
    } elseif ($_GET['act'] == 'aprobar') {
        if (isset($_GET['id_presupuesto'])) {
            $codigo = $_GET['id_presupuesto'];
            $result = mysqli_query($mysqli, "SELECT estado FROM presupuesto WHERE id_presupuesto = $codigo");
            $row = mysqli_fetch_assoc($result);

            if ($row['estado'] === 'rechazado') {
                header("Location: ../../main.php?module=presupuesto&alert=5");
            } else {
                $query = mysqli_query($mysqli, "UPDATE presupuesto SET estado = 'aprobado' WHERE id_presupuesto= $codigo")
                    or die("Error: " . mysqli_error($mysqli));

                if ($query) {
                    header("Location: ../../main.php?module=presupuesto&alert=4");
                } else {
                    header("Location: ../../main.php?module=presupuesto&alert=3");
                }
            }
        }
    }
}
?>