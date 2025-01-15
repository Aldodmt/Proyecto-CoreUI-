<section class="content-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="?module=start"><i class="cil-home"></i>Inicio</a></li>
        <li class="breadcrumb-item active">Tipo de producto</li>
    </ol>
    <br>
    <hr>
    <h1>
        <i class="cil-folder icon-title"></i> Datos de tipos de productos
        <a class="btn btn-primary btn-icon pull-right" href="?module=form_tipo_producto&form=add" title="Agregar" data-toggle="tooltip">
            <i class="cil-plus"></i> Agregar
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
                    <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-label='Close'></button>
                    <h4><i class='cil-check-circle'></i> Exitoso!!!</h4>
                    Datos registrados correctamente </div>";
                }
                elseif($_GET['alert']==2){
                    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-label='Close'></button>
                    <h4><i class='cil-check-circle'></i> Exitoso!!!</h4>
                    Datos modificados correctamente </div>";
                }
                elseif($_GET['alert']==3){
                    echo "<div class='alert alert-success alert-dismissible fade show'>
                    <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-label='Close'></button>
                    <h4><i class='cil-check-circle'></i> Exitoso!!!</h4>
                    Datos eliminados correctamente </div>";
                }
                elseif($_GET['alert']==4){
                    echo "<div class='alert alert-danger alert-dismissible fade show'>
                    <button type='button' class='btn-close' data-coreui-dismiss='alert' aria-label='Close'></button>
                    <h4><i class='cil-x-circle'></i> Error!!!</h4>
                    No se pudo realizar la operación </div>";
                }
            ?>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Lista de tipos de productos</h5>
                    <table id="dataTables1" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">Código</th>
                                <th class="text-center">Tipo de producto</th>
                                <th class="text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $nro = 1;
                                $query = mysqli_query($mysqli, "SELECT *FROM tipo_producto")
                                or die('error'.mysqli_error($mysqli));

                                while($data = mysqli_fetch_assoc($query)){
                                    $cod_tipo_prod = $data['cod_tipo_prod'];
                                    $t_p_descrip = $data['t_p_descrip'];

                                    echo "<tr>
                                    <td class='text-center'>$cod_tipo_prod</td>
                                    <td class='text-center'>$t_p_descrip</td>
                                    <td class='text-center' width='80'>
                                    <div class='btn-group'>
                                    <a data-toggle='tooltip' data-placement='top' title='Modificar datos de tipo de producto' class='btn btn-warning btn-sm' href='?module=form_tipo_producto&form=edit&id=$data[cod_tipo_prod]'>
                                        <i class='cil-pencil'></i> </a>";
                                    ?>
                                    <a data-toggle="tooltip" data-placement="top" title="Eliminar datos" class="btn btn-danger btn-sm" href="modules/tipo_producto/process.php?act=delete&cod_tipo_prod=<?php echo $data['cod_tipo_prod']; ?>" onclick="return confirm('¿Estás seguro/a de eliminar el tipo de producto <?php echo $data['t_p_descrip']; ?>?')">
                                        <i class='cil-trash'></i>
                                    </a>
                                    <?php 
                                    echo "</div>
                                    </td>
                                    </tr>"; ?>
                                <?php } 
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
