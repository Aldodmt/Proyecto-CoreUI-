<section class="content-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="?module=start"><i class="cil-home"></i>Inicio</a></li>
        <li class="breadcrumb-item active"><a href="?module=proveedor">Proveedor</a></li>
    </ol>
    <br>
    <hr>
    <h1>
        <i class="cil-folder icon-title"></i>Datos de proveedores
        <a class="btn btn-primary btn-icon pull-right" href="?module=form_proveedor&form=add" title="Agregar" data-toggle="tooltip">
            <i class="cil-plus"></i>Agregar
        </a>
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-12">
            <?php 
                if(empty($_GET['alert'])){
                    echo "";
                }
                elseif($_GET['alert']==1){
                    echo "<div class='alert alert-success alert-dismissible fade-show' role='alert'>
                    <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-hidden='true'></button>
                    <h4><i class='cil-check-circle'></i>Exitoso!!!</h4>
                    Datos registrados correctamente </div>";
                }
                elseif($_GET['alert']==2){
                    echo "<div class='alert alert-success alert-dismissible fade-show' role='alert'>
                    <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-hidden='true'></button>
                    <h4><i class='cil-check-circle'></i>Exitoso!!!</h4>
                    Datos modificados correctamente </div>";
                }
                elseif($_GET['alert']==3){
                    echo "<div class='alert alert-success alert-dismissible fade-show' role='alert'>
                    <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-hidden='true'></button>
                    <h4><i class='cil-check-circle'></i>Exitoso!!!</h4>
                    Datos eliminados correctamente </div>";
                }
                elseif($_GET['alert']==4){
                    echo "<div class='alert alert-danger alert-dismissible fade-show' role='alert'>
                    <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-hidden='true'></button>
                    <h4><i class='cil-x-circle'></i>Error!!!</h4>
                    No se pudo realizar la operación </div>";
                }
            ?>
            <div class="card">
                <div class="card-body">
                    <section class="content-header">
                        <a class="btn btn-warning btn-icon pull-right" href="modules/proveedor/print.php" target="_blank">
                            <i class="cil-print"></i>Imprimir reporte
                        </a>
                    </section>
                    <table id="dataTables1" class="table table-bordered table-striped table-hover">
                        <h2>Lista de proveedores</h2>
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Razon Social</th>
                                <th class="text-center">RUC</th>
                                <th class="text-center">Dirección</th>
                                <th class="text-center">Teléfono</th>
                                <th class="text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $nro = 1;
                                $query = mysqli_query($mysqli, "SELECT * FROM proveedor")
                                or die('error'.mysqli_error($mysqli));

                                while ($data = mysqli_fetch_assoc($query)) {
                                    $cod_proveedor = $data['cod_proveedor'];
                                    $razon_social = $data['razon_social'];
                                    $ruc = $data['ruc'];
                                    $direccion = $data['direccion'];
                                    $telefono = $data['telefono'];
                                    ?>
                                    <tr>
                                        <td class="text-center"><?php echo $cod_proveedor; ?></td>
                                        <td class="text-center"><?php echo $razon_social; ?></td>
                                        <td class="text-center"><?php echo $ruc; ?></td>
                                        <td class="text-center"><?php echo $direccion; ?></td>
                                        <td class="text-center"><?php echo $telefono; ?></td>
                                        <td class="text-center" width="80">
                                            <div class="btn-group">
                                                <a data-toggle="tooltip" data-placement="top" title="Modificar datos del proveedor"
                                                    style="margin-right:5px" class="btn btn-primary btn-sm"
                                                    href="?module=form_proveedor&form=edit&id=<?php echo $data['cod_proveedor']; ?>">
                                                    <i class="cil-pencil"></i>
                                                </a>
                                                <a data-toggle="tooltip" data-placement="top" title="Eliminar datos"
                                                    class="btn btn-danger btn-sm"
                                                    href="modules/proveedor/process.php?act=delete&cod_proveedor=<?php echo $data['cod_proveedor']; ?>"
                                                    onclick="return confirm('¿Estás seguro/a de eliminar <?php echo $data['razon_social']; ?>?')">
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
