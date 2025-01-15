<section class="content-header">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="?module=start"><i class="cil-home"></i>Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ajuste</a></li>
        </ol>
    </nav>
    <hr>
    <h1>
        <i class="fa fa-folder icon-title"></i> Datos de Ajustes
        <a class="btn btn-primary btn-sm float-end" href="?module=form_ajuste&form=add" title="Agregar"
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
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-label='Close'></button>
                        <h4><i class='fa fa-check-circle'></i> Exitoso!</h4>
                        Ajuste anulado correctamente.
                    </div>";
                } elseif ($_GET["alert"] == 2) {
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-label='Close'></button>
                        <h4><i class='fa fa-exclamation-circle'></i> Error!</h4>
                        No se pudo realizar la operación.
                    </div>";
                } elseif ($_GET["alert"] == 3) {
                    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                        <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-label='Close'></button>
                        <h4><i class='fa fa-check-circle'></i> Exitoso!</h4>
                        Ajuste aprobado correctamente.
                    </div>";
                } elseif ($_GET["alert"] == 5) {
                    echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                        <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-label='Close'></button>
                        <h4><i class='fa fa-check-circle'></i> Error!</h4>
                        No puedes aprobar un ajuste anulado.
                    </div>";
                } elseif ($_GET["alert"] == 6) {
                    echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                        <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-label='Close'></button>
                        <h4><i class='fa fa-check-circle'></i> Error!</h4>
                        El ajuste ya esta anulado.
                    </div>";
                }
            }
            ?>

            <div class="card">
                <div class="card-body">
                    <h2>Lista de Ajustes</h2>
                    <table id="dataTables1" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Usuario</th>
                                <th class="text-center">Fecha</th>
                                <th class="text-center">Producto</th>
                                <th class="text-center">Deposito</th>
                                <th class="text-center">Cantidad Anterior</th>
                                <th class="text-center">Cantidad Ajustada</th>
                                <th class="text-center">Cantidad Final</th>
                                <th class="text-center">Motivo</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $nro = 1;
                            $query = mysqli_query($mysqli, "SELECT * FROM v_ajuste ORDER BY id_ajuste ASC")
                                or die("Error" . mysqli_error($mysqli));
                            while ($data = mysqli_fetch_assoc($query)) {
                                $cod = $data['id_ajuste'];
                                //$cod_c = $data['cod_compra'];
                                $usuario = $data['name_user'];
                                $fecha = $data['fecha_ajuste'];
                                $prod = $data['p_descrip'];
                                $depo = $data['descrip'];
                                $cant_aj = $data['cantidad_ajustada'];
                                $cant_an = $data['cantidad_anterior'];
                                $cant_f = ($data['cantidad_anterior'] - $data['cantidad_ajustada']);
                                $motivo = $data['motivo'];
                                $estado = $data['estado'];
                                echo "<tr>
                                    <td class='text-center'>$cod</td>
                                    <td class='text-center'>$usuario</td>
                                    <td class='text-center'>$fecha</td>
                                    <td class='text-center'>$prod</td>
                                    <td class='text-center'>$depo</td>
                                    <td class='text-center'>$cant_an</td>
                                    <td class='text-center'>$cant_aj</td>
                                    <td class='text-center'>$cant_f</td>
                                    <td class='text-center'>$motivo</td>
                                    <td class='text-center'>$estado</td>
                                    <td class='text-center' width='80'>
                                        <div class='btn-group' role='group'>
                                            <a data-coreui-toggle='tooltip' title='Activar ajuste' class='btn btn-success btn-sm'
                                                href='modules/ajuste/proses.php?act=aprobar&id_ajuste=$cod'
                                                onclick='return confirm(\"¿Estás seguro/a de aprobar el ajuste $cod?\");'>
                                                <i class='cil-check'></i>
                                            </a>
                                            <a data-coreui-toggle='tooltip' title='Anular ajuste' class='btn btn-danger btn-sm'
                                                href='modules/ajuste/proses.php?act=anular&id_ajuste=$cod'
                                                onclick='return confirm(\"¿Estás seguro/a de anular el ajuste $cod?\");'>
                                                <i class='cil-x'></i>
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