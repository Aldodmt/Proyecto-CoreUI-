<section class="content-header">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="?module=start"><i class="cil-home"></i>Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Clientes</a></li>
        </ol>
    </nav><br>
    <hr>
    <h1>
        <i class="fa fa-folder icon-title"></i>Datos de Clientes
        <a class="btn btn-primary btn-social pull-right" href="?module=form_clientes&form=add" title="Agregar"
            data-toggle="tooltip">
            <i class="fa fa-plus"></i>Agregar
        </a>
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?php
            if (empty($_GET['alert'])) {
                echo "";
            } elseif ($_GET["alert"] == 1) {
                echo "<div class='alert alert-success alert-dismissable fade show' role='alert'>
                        <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-label='Close'></button>
                        <strong><i class='fa-solid fa-circle-xmark'></i> Exitoso!</strong> Datos registrados correctamente.
                        </div>";
            } elseif ($_GET["alert"] == 2) {
                echo "<div class='alert alert-success alert-dismissable fade show' role='alert'>
                        <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-label='Close'></button>
                        <strong><i class='fa-solid fa-circle-xmark'></i> Exitoso!</strong> Datos modificados correctamente.
                        </div>";
            } elseif ($_GET["alert"] == 3) {
                echo "<div class='alert alert-success alert-dismissable fade show' role='alert'>
                        <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-label='Close'></button>
                        <strong><i class='fa-solid fa-circle-xmark'></i> Exitoso!</strong> Datos eliminados correctamente.
                        </div>";
            } elseif ($_GET["alert"] == 4) {
                echo "<div class='alert alert-danger alert-dismissable fade show' role='alert'>
                        <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-label='Close'></button>
                        <strong><i class='fa-solid fa-circle-xmark'></i> Error!</strong> No se pudo realizar la operacion.
                        </div>";
            }
            ?>

            <div class="box box-primary">
                <div class="box-body">
                    <section class="content-header">
                        <a class="btn btn-warning btn-social pull-right" href="modules/clientes/print.php" target="new">
                            <i class="cil-print"></i> Imprimir
                        </a>
                    </section>
                    <table id="dataTables1" class="table table-bordered table-striped table-hover">
                        <h2>Lista de clientes</h2>
                        <thead>
                            <tr>
                                <th class="center">ID</th>
                                <th class="center">Ruc</th>
                                <th class="center">Dpto.</th>
                                <th class="center">Ciudad</th>
                                <th class="center">Nombre</th>
                                <th class="center">Apellido</th>
                                <th class="center">Direccion</th>
                                <th class="center">Telefono</th>
                                <th class="center">Accion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $nro = 1;
                            $query = mysqli_query($mysqli, "SELECT * FROM v_clientes")
                                or die("Error" . mysqli_error($mysqli));
                            while ($data = mysqli_fetch_assoc($query)) {
                                $id_cliente = $data['id_cliente'];
                                $ci_ruc = $data['ci_ruc'];
                                $cli_nombre = $data['cli_nombre'];
                                $cli_apellido = $data['cli_apellido'];
                                $cli_direccion = $data['cli_direccion'];
                                $cli_telefono = $data['cli_telefono'];
                                $dep_descripcion = $data['dep_descripcion'];
                                $descrip_ciudad = $data['descrip_ciudad'];


                                echo "<tr>
                                    <td class='center'>$id_cliente</td> 
                                    <td class='center'>$ci_ruc</td>
                                    <td class='center'>$dep_descripcion</td>
                                    <td class='center'>$descrip_ciudad</td>
                                    <td class='center'>$cli_nombre</td>
                                    <td class='center'>$cli_apellido</td>
                                    <td class='center'>$cli_direccion</td>
                                    <td class='center'>$cli_telefono</td>
                                    <td class='center' witdh='80'>
                                    <div>
                                    <a data-toggle='tooltip' data-placement='top' title='Modificar datos de Clientes' style='margin-right:5px' class='btn btn-primary btn-sm' href='?module=form_clientes&form=edit&id=$data[id_cliente]'>
                                    <i class='cil-pencil'></i>
                                    </a>
                                    <a class='btn btn-danger btn-sm' 
                                        href='modules/clientes/proses.php?act=delete&id_cliente=$id_cliente' 
                                        title='Eliminar datos' data-bs-toggle='tooltip'
                                        onclick=\"return confirm('¿Estás seguro/a de eliminar $id_cliente?');\">
                                        <i class='cil-trash'></i>
                                    </a>
                                </div>
                                </td>
                                </tr>";
                                ?>
                            <?php }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</section>