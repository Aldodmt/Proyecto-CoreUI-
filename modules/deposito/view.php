<section class="content-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="?module=start"><i class="cil-home"></i>Inicio</a></liclass>
        <li class="breadcrumb-item active"><a href="?module=deposito">Deposito</a></li>
    </ol>
    <br>
    <hr>
    <h1>
        <i class="cil-folder"></i> Datos de Depósitos
        <a class="btn btn-primary float-right" href="?module=form_deposito&form=add" title="Agregar">
            <i class="cil-plus"></i> Agregar
        </a>
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?php 
                if(empty($_GET['alert'])){
                    echo "";
                }
                elseif($_GET['alert']==1){
                    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Exitoso!</strong> Datos registrados correctamente.
                    <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'></span>
                    </button>
                    </div>";
                }

                elseif($_GET['alert']==2){
                    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Exitoso!</strong> Datos modificados correctamente.
                    <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'></span>
                    </button>
                    </div>";
                }

                elseif($_GET['alert']==3){
                    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Exitoso!</strong> Datos eliminados correctamente.
                    <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'></span>
                    </button>
                    </div>";
                }

                elseif($_GET['alert']==4){
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Error!</strong> No se pudo realizar la operación.
                    <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'></span>
                    </button>
                    </div>";
                }
            ?>
            <div class="card">
                <div class="card-body">
                    <a class="btn btn-warning float-right" href="modules/deposito/print.php" target="_blank">
                        <i class="cil-print"></i> Imprimir reporte
                    </a>
                    <h2 class="card-title">Lista de depósitos</h2>
                    <table id="dataTables1" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">Código</th>
                                <th class="text-center">Depósito</th>
                                <th class="text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $nro = 1;
                                $query = mysqli_query($mysqli, "SELECT * FROM deposito")
                                or die('error'.mysqli_error($mysqli));

                                while ($data = mysqli_fetch_assoc($query)) {
                                    $cod_deposito = $data['cod_deposito'];
                                    $descrip = $data['descrip'];
                                    ?>
                                    <tr>
                                        <td class="text-center"><?php echo $cod_deposito; ?></td>
                                        <td class="text-center"><?php echo $descrip; ?></td>
                                        <td class="text-center" width="80">
                                            <div class="btn-group">
                                                <a data-toggle="tooltip" data-placement="top" title="Modificar datos de deposito"
                                                    style="margin-right:5px" class="btn btn-primary btn-sm"
                                                    href="?module=form_deposito&form=edit&id=<?php echo $data['cod_deposito']; ?>">
                                                    <i class="cil-pencil"></i>
                                                </a>
                                                <a data-toggle="tooltip" data-placement="top" title="Eliminar datos"
                                                    class="btn btn-danger btn-sm"
                                                    href="modules/deposito/process.php?act=delete&cod_deposito=<?php echo $data['cod_deposito']; ?>"
                                                    onclick="return confirm('¿Estás seguro/a de eliminar <?php echo $data['descrip']; ?>?')">
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
