<section class="content-header">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="?module=start"><i class="cil-home"></i>Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Compras</a></li>
        </ol>
    </nav>
    <hr>
    <h1>
        <i class="fa fa-folder icon-title"></i> Datos de Compras
        <a class="btn btn-primary btn-sm float-end" href="?module=form_compras&form=add" title="Agregar"
            data-coreui-toggle="tooltip">
            <i class="fa fa-plus"></i> Agregar
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
                        Datos registrados correctamente.
                    </div>";
                } elseif ($_GET["alert"] == 2) {
                    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                        <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-label='Close'></button>
                        <h4><i class='fa fa-check-circle'></i> Exitoso!</h4>
                        Datos anulados correctamente.
                    </div>";
                } elseif ($_GET["alert"] == 3) {
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-label='Close'></button>
                        <h4><i class='fa fa-exclamation-circle'></i> Error!</h4>
                        No se pudo realizar la operación.
                    </div>";
                } elseif ($_GET["alert"] == 4) {
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-label='Close'></button>
                        <h4><i class='fa fa-exclamation-circle'></i> Error!</h4>
                        El timbrado supero su limite.
                    </div>";
                }
            }
            ?>

            <div class="card">
                <div class="card-body">
                    <h2>Lista de Compras</h2>
                    <table id="dataTables1" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">ID orden de compra</th>
                                <th class="text-center">Usuario</th>
                                <th class="text-center">Fecha</th>
                                <th class="text-center">Hora</th>
                                <th class="text-center">Proveedor</th>
                                <th class="text-center">Depósito</th>
                                <th class="text-center">Nro. Factura</th>
                                <th class="text-center">Nro. Timbrado</th>
                                <th class="text-center">Timbrado Vencimiento</th>
                                <th class="text-center">Producto</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-center">Precio</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $nro = 1;
                            $query = mysqli_query($mysqli, "SELECT * FROM v_compras WHERE estado = 'activo'")
                                or die("Error" . mysqli_error($mysqli));
                            while ($data = mysqli_fetch_assoc($query)) {
                                $cod = $data['cod_compra'];
                                $cod_orden = $data['id_orden_comp'];
                                $proveedor = $data['razon_social'];
                                $deposito = $data['descrip'];
                                $nro_factura = $data['nro_factura'];
                                $formato_factura = "000-000-" . str_pad($nro_factura, 3, "0", STR_PAD_LEFT);
                                $fecha = $data['fecha'];
                                $hora = $data['hora'];
                                $prod = $data['p_descrip'];
                                $cantidad = $data['cantidad'];
                                $precio = $data['precio'];
                                $total = ($data['cantidad'] * $data['precio']);
                                $estado = $data['estado'];
                                $usuario = $data['name_user'];
                                $nro_timbrado = $data['nro_timbrado'];
                                $timbri_vencimiento = $data['timbrado_vencimiento'];

                                echo "<tr>
                                    <td class='text-center'>$cod</td>
                                    <td class='text-center'>$cod_orden</td> 
                                    <td class='text-center'>$usuario</td>
                                    <td class='text-center'>$fecha</td>
                                    <td class='text-center'>$hora</td>
                                    <td class='text-center'>$proveedor</td>
                                    <td class='text-center'>$deposito</td>
                                    <td class='text-center'>$nro_factura</td>
                                    <td class='text-center'>$nro_timbrado</td>
                                    <td class='text-center'>$timbri_vencimiento</td>
                                    <td class='text-center'>$prod</td>
                                    <td class='text-center'>$cantidad</td>
                                    <td class='text-center'>$precio</td>
                                    <td class='text-center'>$total</td>
                                    <td class='text-center'>$estado</td>
                                    <td class='text-center' width='80'>
                                        <div class='btn-group' role='group'>
                                            <a data-coreui-toggle='tooltip' title='Anular compra' class='btn btn-danger btn-sm'
                                                href='modules/compras/proses.php?act=anular&cod_compra=$cod'
                                                onclick='return confirm(\"¿Estás seguro/a de anular la factura $nro_factura?\");'>
                                                <i class='cil-trash'></i>
                                            </a>
                                            <a data-coreui-toggle='tooltip' title='Imprimir factura de compra' class='btn btn-warning btn-sm'
                                                href='modules/compras/print.php?act=imprimir&cod_compra=$cod' target='_blank'>
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