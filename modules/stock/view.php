<section class="container-fluid">
    <div class="row mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="?module=start"><i class="cil-home"></i> Inicio</a>
            </li>
            <li class="breadcrumb-item">
                <a>Stock</a>
            </li>
        </ol>
    </div>

    <div class="row">
        <div class="col">
            <h1 class="display-6">
                <i class="cil-folder"></i> Stock de productos
            </h1>
            <hr>
        </div>
    </div>
</section>

<section class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form method="POST" class="row g-3">
                        <div class="col-md-4">
                            <label for="cod_deposito" class="form-label">Depósito</label>
                            <select class="form-select" name="cod_deposito" id="cod_deposito" required>
                                <option value="" disabled selected>--Seleccione un depósito--</option>
                                <?php
                                $query_dep = mysqli_query($mysqli, "SELECT cod_deposito, descrip FROM deposito ORDER BY cod_deposito ASC")
                                    or die("error" . mysqli_error($mysqli));
                                while ($data_dep = mysqli_fetch_assoc($query_dep)) {
                                    echo "<option value=\"$data_dep[cod_deposito]\">$data_dep[cod_deposito] | $data_dep[descrip]</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4 align-self-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="cil-magnifying-glass"></i> Buscar depósito
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <?php
            $cod_deposito = $_POST['cod_deposito'] ?? 1;
            $query = mysqli_query($mysqli, "SELECT * FROM v_stock WHERE cod_deposito=$cod_deposito;")
                or die('error' . mysqli_error($mysqli));

            $deposito = "";
            if ($data = mysqli_fetch_assoc($query)) {
                $deposito = $data['descrip'];
            }
            ?>
            <div class="card mt-4">
                <div class="card-header">
                    <h2 class="h4">Lista de productos en Stock: <?php echo $deposito; ?></h2>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">Depósito</th>
                                <th class="text-center">Tip. Producto</th>
                                <th class="text-center">Producto</th>
                                <th class="text-center">Unid. Medida</th>
                                <th class="text-center">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = mysqli_query($mysqli, "SELECT * FROM v_stock WHERE cod_deposito=$cod_deposito;")
                                or die('error' . mysqli_error($mysqli));

                            while ($data = mysqli_fetch_assoc($query)) {
                                echo "<tr>
                                        <td class='text-center'>{$data['descrip']}</td>
                                        <td class='text-center'>{$data['t_p_descrip']}</td>
                                        <td class='text-center'>{$data['p_descrip']}</td>
                                        <td class='text-center'>{$data['u_descrip']}</td>
                                        <td class='text-center'>{$data['cantidad']}</td>
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