<?php
if ($_GET['form'] == 'add') { ?>
    <section class="content-header">
        <h1>
            <i class="fa fa-edit icon-title"></i>Agregar ciudad
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="?module=start"><i class="cil-home"></i>Inicio</a></li>
            <li class="breadcrumb-item"><a href="?module=producto">Productos</a></li>
            <li class="breadcrumb-item active">Agregar</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form role="form" class="form-horizontal" action="modules/producto/process.php?act=insert"
                            method="POST">
                            <div class="form-group">
                                <?php
                                // Método para generar código
                                $query_id = mysqli_query($mysqli, "SELECT MAX(cod_producto) as id FROM producto") or die('error' . mysqli_error($mysqli));
                                $count = mysqli_num_rows($query_id);
                                if ($count <> 0) {
                                    $data_id = mysqli_fetch_assoc($query_id);
                                    $codigo = $data_id['id'] + 1;
                                } else {
                                    $codigo = 1;
                                }
                                ?>
                                <label class="col-sm-2 col-form-label">Código</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="codigo" value="<?php echo $codigo; ?>"
                                        readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 col-form-label">Producto</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="p_descrip"
                                        placeholder="Ingrese un producto" required>
                                </div>
                            </div>

                            <!-- Combo buscador -->
                            <div class="form-group">
                                <label class="col-sm-2 col-form-label">Tipo de producto</label>
                                <div class="col-sm-5">
                                    <select class="form-control" name="tipo_producto"
                                        data-placeholder="--Seleccione el tipo de producto--" autocomplete="off" required>
                                        <option value=""></option>
                                        <?php
                                        $query_tp = mysqli_query($mysqli, "SELECT *FROM tipo_producto") or die('error' . mysqli_error($mysqli));
                                        while ($data_tp = mysqli_fetch_assoc($query_tp)) {
                                            echo "<option value=\"$data_tp[cod_tipo_prod]\">$data_tp[t_p_descrip]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Combo buscador -->
                            <div class="form-group">
                                <label class="col-sm-2 col-form-label">Unidad de medida</label>
                                <div class="col-sm-5">
                                    <select class="form-control" name="u_medida"
                                        data-placeholder="--Seleccione la unidad de medida--" autocomplete="off" required>
                                        <option value=""></option>
                                        <?php
                                        $query_um = mysqli_query($mysqli, "SELECT *FROM u_medida") or die('error' . mysqli_error($mysqli));
                                        while ($data_um = mysqli_fetch_assoc($query_um)) {
                                            echo "<option value=\"$data_um[id_u_medida]\">$data_um[u_descrip]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group ">
                                <label class="col-sm-2 col-form-label">Precio</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="precio"
                                        placeholder="Ingrese el precio del producto" required>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="form-group row">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <input type="submit" class="btn btn-primary" name="Guardar" value="Guardar">
                                        <a href="?module=producto" class="btn btn-secondary">Cancelar</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } elseif ($_GET['form'] == 'edit') {
    if (isset($_GET['id'])) {
        $query = mysqli_query($mysqli, "SELECT *FROM producto WHERE cod_producto = '$_GET[id]'") or die('error' . mysqli_error($mysqli));
        $data = mysqli_fetch_assoc($query);
    } ?>
    <section class="content-header">
        <h1>
            <i class="fa fa-edit icon-title"></i>Modificar producto
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="?module=start"><i class="fa fa-home"></i>Inicio</a></li>
            <li class="breadcrumb-item"><a href="?module=producto">Productos</a></li>
            <li class="breadcrumb-item active">Modificar</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form role="form" class="form-horizontal" action="modules/producto/process.php?act=update"
                            method="POST">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Código</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="codigo"
                                        value="<?php echo $data['cod_producto']; ?>" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 col-form-label">Producto</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="p_descrip"
                                        value="<?php echo $data['p_descrip']; ?>" required>
                                </div>
                            </div>

                            <!-- Combo buscador -->
                            <div class="form-group">
                                <label class="col-sm-2 col-form-label">Tipo de producto</label>
                                <div class="col-sm-5">
                                    <select class="form-control" name="tipo_producto"
                                        data-placeholder="--Seleccione un tipo de producto--" autocomplete="off" required>
                                        <option value="<?php echo $data['cod_tipo_prod']; ?>">
                                            <?php echo $data['t_p_descrip']; ?>
                                        </option>
                                        <?php
                                        $query_tp = mysqli_query($mysqli, "SELECT *FROM tipo_producto") or die('error' . mysqli_error($mysqli));
                                        while ($data_tp = mysqli_fetch_assoc($query_tp)) {
                                            echo "<option value=\"$data_tp[cod_tipo_prod]\">$data_tp[t_p_descrip]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Combo buscador -->
                            <div class="form-group">
                                <label class="col-sm-2 col-form-label">Unidad de medida</label>
                                <div class="col-sm-5">
                                    <select class="form-control" name="u_medida"
                                        data-placeholder="--Seleccione un tipo de producto--" required>
                                        <option value="<?php echo $data['id_u_medida']; ?>">
                                            <?php echo $data['u_descrip']; ?>
                                        </option>
                                        <?php
                                        $query_um = mysqli_query($mysqli, "SELECT * FROM u_medida") or die('error' . mysqli_error($mysqli));
                                        while ($data_um = mysqli_fetch_assoc($query_um)) {
                                            echo "<option value=\"$data_um[id_u_medida]\">$data_um[u_descrip]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 col-form-label">Precio</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="precio"
                                        value="<?php echo $data['precio']; ?>" required>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <input type="submit" class="btn btn-primary" name="Guardar" value="Guardar">
                                        <a href="?module=producto" class="btn btn-secondary">Cancelar</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php }
