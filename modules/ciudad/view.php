<section class="content-header">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="?module=start"><i class="cil-home"></i>Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ciudad</a></li>
        </ol>
    </nav>
    <hr>
    <h1>
        <i class="cil-folder icon-title"></i>Datos de Ciudad
        <a class="btn btn-primary btn-social pull-right" href="?module=form_ciudad&form=add" title="Agregar"
            data-toggle="tooltip">
            <i class="cil-plus"></i>Agregar
        </a>
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-12">
            <?php
            if (empty($_GET['alert'])) {
                echo "";
            } elseif ($_GET["alert"] == 1) {
                echo "<div class='alert alert-success alert-dismissible fade show'>
                    <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-label='Close'>&times;</button>
                    <h4> <i class='cil-check-circle'></i> Exitoso!</h4>
                    Datos registrados correctamente
                </div>";
            } elseif ($_GET["alert"] == 2) {
                echo "<div class='alert alert-success alert-dismissible fade show'>
                    <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-label='Close'>&times;</button>
                    <h4> <i class='cil-check-circle'></i> Exitoso!</h4>
                    Datos modificados correctamente
                </div>";
            } elseif ($_GET["alert"] == 3) {
                echo "<div class='alert alert-success alert-dismissible fade show'>
                    <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-label='Close'>&times;</button>
                    <h4> <i class='cil-check-circle'></i> Exitoso!</h4>
                    Datos eliminados correctamente
                </div>";
            } elseif ($_GET["alert"] == 4) {
                echo "<div class='alert alert-danger alert-dismissible fade show'>
                    <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-label='Close'>&times;</button>
                    <h4> <i class='cil-x-circle'></i> Error!</h4>
                    No se pudo realizar la operación
                </div>";
            }
            ?>

            <div class="card">
                <div class="card-body">
                    <table id="dataTables1" class="table table-bordered table-striped table-hover">
                        <section class="content-header">
                            <a class="btn btn-warning btn-social pull-right" href="modules/ciudad/print.php"
                                target="_blank">
                                <i class="cil-print"></i> Imprimir
                            </a>
                        </section>

                        <h2>Lista de ciudad</h2>
                        <thead>
                            <tr>
                                <th class="text-center">Código</th>
                                <th class="text-center">Descripción</th>
                                <th class="text-center">Departamento</th>
                                <th class="text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $nro = 1;
                            $query = mysqli_query($mysqli, "SELECT ciu.cod_ciudad, ciu.descrip_ciudad, dep.id_departamento, dep.dep_descripcion 
                            FROM ciudad ciu
                            JOIN departamento dep ON ciu.id_departamento = dep.id_departamento")
                                or die("Error" . mysqli_error($mysqli));
                            while ($data = mysqli_fetch_assoc($query)) {
                                $cod_ciudad = $data['cod_ciudad'];
                                $descrip_ciudad = $data['descrip_ciudad'];
                                $dep_descripcion = $data['dep_descripcion'];
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $cod_ciudad; ?></td>
                                    <td class="text-center"><?php echo $descrip_ciudad; ?></td>
                                    <td class="text-center"><?php echo $dep_descripcion; ?></td>
                                    <td class="text-center" width="80">
                                        <div class="btn-group">
                                            <a data-toggle="tooltip" data-placement="top" title="Modificar datos de Ciudad"
                                                style="margin-right:5px" class="btn btn-primary btn-sm"
                                                href="?module=form_ciudad&form=edit&id=<?php echo $data['cod_ciudad']; ?>">
                                                <i class="cil-pencil"></i>
                                            </a>
                                            <a data-toggle="tooltip" data-placement="top" title="Eliminar datos"
                                                class="btn btn-danger btn-sm"
                                                href="modules/ciudad/proses.php?act=delete&cod_ciudad=<?php echo $data['cod_ciudad']; ?>"
                                                onclick="return confirm('¿Estás seguro/a de eliminar <?php echo $data['descrip_ciudad']; ?>?')">
                                                <i class="cil-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>