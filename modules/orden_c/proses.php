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
                        $codigo_producto = $producto['codigoProducto'];
                        $cantidad = $producto['cantidad'];

                        $presu = mysqli_query($mysqli, "SELECT precio_unit FROM v_presu where cod_producto = " . $codigo_producto . " ");
                        $datos = mysqli_fetch_array($presu);
                        $precio_unit = $datos['precio_unit'];

                        // Insertar los productos en la tabla detalle_orden_comp
                        $insert_detalle = mysqli_query($mysqli, "INSERT INTO detalle_orden_comp (id_orden_comp, cod_producto, precio_unit, cantidad_aprobada) 
                            VALUES ($codigo, '$codigo_producto', $precio_unit, $cantidad)")
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
            $sql_p = mysqli_query($mysqli, "SELECT * FROM v_presu, tmp_orden WHERE v_presu.id_presupuesto = tmp_orden.id_presupuesto");
            $data = mysqli_fetch_array($sql_p);

            // Insertar cabecera de orden
            $codigo_presu = $data['id_presupuesto'];
            //$codigo_proveedor = $_POST['codigo_proveedor'];
            $fecha = $_POST['fecha'];

            //Ya no hace falta la validacion de fecha
            /*if (strtotime($fecha_v))) {
                echo "<script>
                alert('Error: La fecha de vencimiento no puede ser menor que la fecha de emisión.');
                window.history.back();
              </script>";
                exit;
            }*/

            $hora = $_POST['hora'];
            $estado = 'pendiente';
            $usuario = $_SESSION['id_user'];
            $query = mysqli_query($mysqli, "INSERT INTO orden_compra (id_orden_comp, fecha, estado, hora, id_user, id_presupuesto) 
                VALUES ($codigo, '$fecha', '$estado', '$hora', $usuario, $codigo_presu)")
                or die("Error" . mysqli_error($mysqli));

            if ($query) {
                header("Location: ../../main.php?module=orden_c&alert=1");
            } else {
                header("Location: ../../main.php?module=orden_c&alert=3");
            }
        }
    } elseif ($_GET['act'] == 'anular') {
        if (isset($_GET['id_orden'])) {
            $codigo = $_GET['id_orden'];

            $result = mysqli_query($mysqli, "SELECT estado FROM orden_compra WHERE id_orden_comp = $codigo");
            $row = mysqli_fetch_assoc($result);

            if ($row['estado'] === 'rechazado') {
                header("Location: ../../main.php?module=orden_c&alert=6");
            } else {
                $query = mysqli_query($mysqli, "UPDATE orden_compra SET estado = 'rechazado' WHERE id_orden_comp= $codigo")
                    or die("Error: " . mysqli_error($mysqli));

                if ($query) {
                    header("Location: ../../main.php?module=orden_c&alert=2");
                } else {
                    header("Location: ../../main.php?module=orden_c&alert=3");
                }
            }
        }
    } elseif ($_GET['act'] == 'aprobar') {
        if (isset($_GET['id_orden'])) {
            $codigo = $_GET['id_orden'];
            // Verificar si el estado no es 'rechazado'
            $result = mysqli_query($mysqli, "SELECT estado FROM orden_compra WHERE id_orden_comp = $codigo");
            $row = mysqli_fetch_assoc($result);

            if ($row['estado'] === 'rechazado') {
                header("Location: ../../main.php?module=orden_c&alert=5");
            } else {
                $query = mysqli_query($mysqli, "UPDATE orden_compra SET estado = 'aprobado' WHERE id_orden_comp= $codigo")
                    or die("Error: " . mysqli_error($mysqli));

                if ($query) {
                    header("Location: ../../main.php?module=orden_c&alert=4");
                } else {
                    header("Location: ../../main.php?module=orden_c&alert=3");
                }
            }
        }
    }
}
?>