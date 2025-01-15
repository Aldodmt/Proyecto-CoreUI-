<section class="content-header">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="?module=start"><i class="cil-home"></i>Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Orden de compra</a></li>
        </ol>
    </nav>
    <hr>
    <h1>
        <i class="fa fa-folder icon-title"></i> Datos de Orden de Compra
        <a class="btn btn-primary btn-sm float-end" href="?module=form_orden_c&form=add" title="Agregar"
            data-coreui-toggle="tooltip">
            <i class="cil-plus"></i> Agregar
        </a>
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?php
            if (!empty($_GET['alert'])) {
                if ($_GET["alert"] == 1) {
                    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                        <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-label='Close'></button>
                        <h4><i class='fa fa-check-circle'></i> Exitoso!</h4>
                        Orden registrada correctamente.
                    </div>";
                } elseif ($_GET["alert"] == 2) {
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-label='Close'></button>
                        <h4><i class='fa fa-check-circle'></i> Exitoso!</h4>
                        Orden rechazada correctamente.
                    </div>";
                } elseif ($_GET["alert"] == 3) {
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-label='Close'></button>
                        <h4><i class='fa fa-exclamation-circle'></i> Error!</h4>
                        No se pudo realizar la operación.
                    </div>";
                } elseif ($_GET["alert"] == 4) {
                    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                        <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-label='Close'></button>
                        <h4><i class='fa fa-check-circle'></i> Exitoso!</h4>
                        Orden aprobada.
                    </div>";
                } elseif ($_GET["alert"] == 5) {
                    echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                        <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-label='Close'></button>
                        <h4><i class='fa fa-check-circle'></i> Error!</h4>
                        No puedes aprobar una orden rechazada.
                    </div>";
                } elseif ($_GET["alert"] == 6) {
                    echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                        <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-label='Close'></button>
                        <h4><i class='fa fa-check-circle'></i> Error!</h4>
                        La orden ya esta rechazada.
                    </div>";
                }
            }
            ?>

            <div class="card">
                <div class="card-body">
                    <h2>Lista de Presupuesto</h2>
                    <table id="dataTables1" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">ID Presupuesto</th>
                                <th class="text-center">Usuario</th>
                                <th class="text-center">Fecha</th>
                                <th class="text-center">Hora</th>
                                <th class="text-center">Producto</th>
                                <th class="text-center">Cantidad Aprobada</th>
                                <th class="text-center">Precio Unitario</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            //$nro = 1;
                            $query = mysqli_query($mysqli, "SELECT * FROM v_orden_comp where estado = 'rechazado' or estado = 'pendiente' ORDER BY id_orden_comp ASC")
                                or die("Error" . mysqli_error($mysqli));
                            while ($data = mysqli_fetch_assoc($query)) {
                                $cod = $data['id_orden_comp'];
                                $cod_p = $data['id_presupuesto'];
                                $user = $data['name_user'];
                                $fecha = $data['fecha'];
                                $hora = $data['hora'];
                                $prod = $data['p_descrip'];
                                $cantidad = $data['cantidad_aprobada'];
                                $precio = $data['precio_unit'];
                                $total = ($data['cantidad_aprobada'] * $data['precio_unit']);
                                $estado = $data['estado'];

                                //por si  acaso
                                /*$precio_compra_ = $row['precio_tmp'];
        $precio_compra_f = number_format($precio_compra_); //Formatear una variable (Poner ,)
        $precio_compra_r = str_replace(",", "", $precio_compra_f); //Reemplazar la coma 
        $precio_total = $precio_compra_r * $cantidad;
        $precio_total_f = number_format($precio_total);
        $precio_total_r = str_replace(",", "", $precio_total_f);*/

                                echo "<tr>
                                    <td class='text-center'>$cod</td>
                                    <td class='text-center'>$cod_p</td>
                                    <td class='text-center'>$user</td>
                                    <td class='text-center'>$fecha</td>
                                    <td class='text-center'>$hora</td>
                                    <td class='text-center'>$prod</td>
                                    <td class='text-center'>$cantidad</td>
                                    <td class='text-center'>$precio</td>
                                    <td class='text-center'>$total</td>
                                    <td class='text-center'>$estado</td>
                                    <td class='text-center' width='80'>
                                        <div class='btn-group' role='group'>
                                            <a data-coreui-toggle='tooltip' title='Aprobar pedido' class='btn btn-success btn-sm'
                                                href='modules/orden_c/proses.php?act=aprobar&id_orden=$cod'
                                                onclick='return confirm(\"¿Estás seguro/a de aprobar el pedido $cod?\");'>
                                                <i class='cil-check'></i>
                                            </a>
                                            <a data-coreui-toggle='tooltip' title='Rechazar pedido' class='btn btn-danger btn-sm'
                                                href='modules/orden_c/proses.php?act=anular&id_orden=$cod'
                                                onclick='return confirm(\"¿Estás seguro/a de rechzar el pedido $cod?\");'>
                                                <i class='cil-x'></i>
                                            </a>
                                            <a data-coreui-toggle='tooltip' title='Imprimir factura de la orden' class='btn btn-warning btn-sm'
                                                href='modules/orden_c/print.php?act=imprimir&id_orden=$cod' target='_blank'>
                                                <i class='cil-print'></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>