<section class="content-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="?module=start"><i class="cil-home"></i>Inicio</a></li>
        <li class="breadcrumb-item active"><a href="?module=producto">Productos</a></li>
    </ol>
    <br>
    <hr>
    <h1>
        <i class="cil-folder-open icon-title"></i>Datos de productos
        <a class="btn btn-primary btn-sm pull-right" href="?module=form_producto&form=add" title="Agregar" data-toggle="tooltip">
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
                    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-hidden='true'></button>
                    <h4><i class='cil-check-circle'></i>Exitoso!!!</h4>
                    Datos registrados correctamente </div>";
                }

                elseif($_GET['alert']==2){
                    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-hidden='true'></button>
                    <h4><i class='cil-check-circle'></i>Exitoso!!!</h4>
                    Datos modificados correctamente </div>";
                }

                elseif($_GET['alert']==3){
                    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-hidden='true'></button>
                    <h4><i class='cil-check-circle'></i>Exitoso!!!</h4>
                    Datos eliminados correctamente </div>";
                }

                elseif($_GET['alert']==4){
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-label='Close'></button>
                    <h4><i class='cil-x-circle'></i>Error!!!</h4>
                    No se pudo realizar la operacion </div>";
                }
            ?>
            <div class="card">
                <div class="card-body">
                    <section class="content-header">
                        <a class="btn btn-warning btn-sm pull-right" href="modules/producto/print.php" target="_blank">
                            <i class="cil-print"></i>Imprimir reporte
                        </a>
                    </section>
                    <table id="dataTables1" class="table table-bordered table-striped table-hover">
                        <h2>Lista de productos</h2>
                        <thead>
                            <tr>
                                <th class="text-center">Código</th>
                                <th class="text-center">Producto</th>
                                <th class="text-center">Tip. de prod.</th>
                                <th class="text-center">Unid. de medida</th>
                                <th class="text-center">Precio</th>
                                <th class="text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $nro = 1;
                                $query = mysqli_query($mysqli, "SELECT * FROM v_producto")
                                or die('error'.mysqli_error($mysqli));

                                while ($data = mysqli_fetch_assoc($query)) {
                                    $cod_producto = $data['cod_producto'];
                                    $p_descrip = $data['p_descrip'];
                                    $tipo_producto = $data['t_p_descrip'];
                                    $u_medida = $data['u_descrip'];
                                    $precio = $data['precio'];
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $cod_producto; ?></td>
                                <td class="text-center"><?php echo $p_descrip; ?></td>
                                <td class="text-center"><?php echo $tipo_producto; ?></td>
                                <td class="text-center"><?php echo $u_medida; ?></td>
                                <td class="text-center"><?php echo $precio; ?></td>
                                <td class="text-center" width="80">
                                    <div class="btn-group">
                                        <a data-toggle="tooltip" data-placement="top" title="Modificar datos de producto"
                                            style="margin-right:5px" class="btn btn-primary btn-sm"
                                            href="?module=form_producto&form=edit&id=<?php echo $data['cod_producto']; ?>">
                                            <i class="cil-pencil"></i>
                                        </a>
                                        <a data-toggle="tooltip" data-placement="top" title="Eliminar datos"
                                            class="btn btn-danger btn-sm"
                                            href="modules/producto/process.php?act=delete&cod_producto=<?php echo $data['cod_producto']; ?>"
                                            onclick="return confirm('¿Estás seguro/a de eliminar el producto <?php echo $data['p_descrip']; ?>?')">
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
