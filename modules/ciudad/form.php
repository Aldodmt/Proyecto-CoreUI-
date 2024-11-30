<?php
if ($_GET['form'] == 'add') { ?>
    <section class="content-header">
        <h1>
            <i class="cil-pencil icon-title"></i>Agregar Ciudad
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="?module=start"><i class="cil-home"></i>Inicio</a></li>
            <li class="breadcrumb-item"><a href="?module=ciudad">Ciudad</a></li>
            <li class="breadcrumb-item active">Agregar</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form role="form" class="form-horizontal" action="modules/ciudad/proses.php?act=insert"
                            method="POST">
                            <div class="form-group">
                                <?php
                                // Método para generar código
                                $query_id = mysqli_query($mysqli, "SELECT MAX(cod_ciudad) as id FROM ciudad")
                                    or die("Error en consulta: " . mysqli_error($mysqli));
                                $count = mysqli_num_rows($query_id);
                                $codigo = ($count != 0) ? mysqli_fetch_assoc($query_id)['id'] + 1 : 1;
                                ?>
                                <label for="codigo" class="col-sm-2 col-form-label">Código</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="codigo" value="<?php echo $codigo; ?>"
                                        readonly>
                                </div>
                            </div>

                            <!-- Combo para seleccionar departamento -->
                            <div class="form-group">
                                <label for="departamento" class="col-sm-2 col-form-label">Departamento</label>
                                <div class="col-sm-5">
                                    <select name="departamento" class="form-control">
                                        <option value=""></option>
                                        <?php
                                        $query = mysqli_query($mysqli, 'SELECT * FROM departamento')
                                            or die('Error: ' . mysqli_error($mysqli));
                                        while ($data = mysqli_fetch_assoc($query)) {
                                            $selected = ($_POST['departamento'] == $data['id_departamento']) ? 'selected' : '';
                                            echo "<option value='" . $data['id_departamento'] . "' $selected>" . htmlspecialchars($data['dep_descripcion']) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="descrip_ciudad" class="col-sm-2 col-form-label">Descripción</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="descrip_ciudad"
                                        placeholder="Ingresa una ciudad" required>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-primary" name="Guardar">Guardar</button>
                                        <a href="?module=ciudad" class="btn btn-secondary">Cancelar</a>
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
        $id_ciudad = mysqli_real_escape_string($mysqli, $_GET['id']);
        $query = mysqli_query($mysqli, "SELECT * FROM ciudad WHERE cod_ciudad = '$id_ciudad'")
            or die("Error en consulta: " . mysqli_error($mysqli));

        if (mysqli_num_rows($query) > 0) {
            $data = mysqli_fetch_assoc($query);
        } else {
            echo "Ciudad no encontrada.";
            exit;
        }
    } ?>
    <section class="content-header">
        <h1>
            <i class="cil-pencil icon-title"></i>Modificar Ciudad
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="?module=start"><i class="cil-home"></i>Inicio</a></li>
            <li class="breadcrumb-item"><a href="?module=ciudad">Ciudad</a></li>
            <li class="breadcrumb-item active">Modificar</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form role="form" class="form-horizontal" action="modules/ciudad/proses.php?act=update"
                            method="POST">
                            <div class="form-group">
                                <label for="codigo" class="col-sm-2 col-form-label">Código</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="codigo"
                                        value="<?php echo $data['cod_ciudad']; ?>" readonly>
                                </div>
                            </div>

                            <!-- Combo para seleccionar departamento -->
                            <div class="form-group">
                                <label for="departamento" class="col-sm-2 col-form-label">Departamento</label>
                                <div class="col-sm-5">
                                    <select name="departamento" class="form-control">
                                        <option value="<?php echo $data['id_departamento']; ?>">
                                            <?php echo htmlspecialchars($data['dep_descripcion']); ?>
                                        </option>
                                        <?php
                                        $query = mysqli_query($mysqli, 'SELECT * FROM departamento')
                                            or die('Error: ' . mysqli_error($mysqli));
                                        while ($data2 = mysqli_fetch_assoc($query)) {
                                            $selected = ($data['id_departamento'] == $data2['id_departamento']) ? 'selected' : '';
                                            echo "<option value='" . $data2['id_departamento'] . "' $selected>" . htmlspecialchars($data2['dep_descripcion']) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="descrip_ciudad" class="col-sm-2 col-form-label">Descripción</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="descrip_ciudad"
                                        value="<?php echo htmlspecialchars($data['descrip_ciudad']); ?>" required>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-primary" name="Guardar">Guardar</button>
                                        <a href="?module=ciudad" class="btn btn-secondary">Cancelar</a>
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
?>