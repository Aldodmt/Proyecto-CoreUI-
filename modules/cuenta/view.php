<section class="content-header">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="?module=start"><i class="cil-home"></i>Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cuentas a pagar</a></li>
        </ol>
    </nav>
    <hr>
    <h1>
        <i class="fa fa-folder icon-title"></i> Datos de cuentas a pagar
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
                        Presupuesto registrado correctamente.
                    </div>";
                } elseif ($_GET["alert"] == 2) {
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-label='Close'></button>
                        <h4><i class='fa fa-check-circle'></i> Exitoso!</h4>
                        Cuenta deshabilitada correctamente.
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
                        Cuenta activada correctamente.
                    </div>";
                }
            }
            ?>

            <div class="card">
                <div class="card-body">
                    <h2>Lista de cuentas a pagar</h2>
                    <table id="dataTables1" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">ID compra</th>
                                <th class="text-center">Proveedor</th>
                                <th class="text-center">Fecha Emitida</th>
                                <th class="text-center">Fecha de Vencimiento</th>
                                <th class="text-center">Monto total</th>
                                <th class="text-center">Monto pagado</th>
                                <th class="text-center">Saldo Pendiente</th>
                                <th class="text-center">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $nro = 1;
                            $query = mysqli_query($mysqli, "SELECT * FROM v_cuentas WHERE estado = 'pendiente' ORDER BY id_cuenta ASC")
                                or die("Error" . mysqli_error($mysqli));
                            while ($data = mysqli_fetch_assoc($query)) {
                                $cod = $data['id_cuenta'];
                                $cod_p = $data['cod_compra'];
                                $razon = $data['razon_social'];
                                $fecha = $data['fecha_emision'];
                                $fecha_v = $data['fecha_vencimiento'];
                                $monto_t = $data['monto_total'];
                                $monto_p = $data['monto_pagado'];
                                $saldo = ($monto_t - $monto_p);
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
                                    <td class='text-center'>$razon</td>
                                    <td class='text-center'>$fecha</td>
                                    <td class='text-center'>$fecha_v</td>
                                    <td class='text-center'>$monto_t</td>
                                    <td class='text-center'>$monto_p</td>
                                    <td class='text-center'>$saldo</td>
                                    <td class='text-center'>$estado</td>
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