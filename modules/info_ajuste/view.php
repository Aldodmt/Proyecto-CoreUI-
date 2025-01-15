<section class="container-fluid">
    <div class="row mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="?module=start"><i class="cil-home"></i> Inicio</a>
            </li>
            <li class="breadcrumb-item">
                <a>Filtrar Ajustes</a>
            </li>
        </ol>
    </div>

    <div class="row">
        <div class="col">
            <h1 class="display-12">
                <i class="cil-filter"></i> Filtrar Ajustes
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
                            <label for="fecha_desde" class="form-label">Fecha Desde</label>
                            <input type="date" class="form-control" name="fecha_desde" id="fecha_desde" required>
                        </div>
                        <div class="col-md-4">
                            <label for="fecha_hasta" class="form-label">Fecha Hasta</label>
                            <input type="date" class="form-control" name="fecha_hasta" id="fecha_hasta" required>
                        </div>
                        <div class="col-md-4">
                            <label for="estado" class="form-label">Estado</label>
                            <select class="form-select" name="estado" id="estado" required>
                                <option value="" disabled selected>--Seleccione un estado--</option>
                                <option value="activo">Activo</option>
                                <option value="anulado">Anulado</option>
                                <option value="pendiente">Pendiente</option>
                            </select>
                        </div>
                        <div class="col-md-12 text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="cil-magnifying-glass"></i> Buscar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <?php
            // Capturar valores del formulario
            $fecha_desde = $_POST['fecha_desde'] ?? null;
            $fecha_hasta = $_POST['fecha_hasta'] ?? null;
            $estado = $_POST['estado'] ?? null;

            // Validar que todos los campos estén completos
            if ($fecha_desde && $fecha_hasta && $estado) {
                $query = mysqli_query($mysqli, "
                    SELECT * 
                    FROM v_ajuste
                    WHERE fecha_ajuste BETWEEN '$fecha_desde' AND '$fecha_hasta'
                    AND estado = '$estado'
                ") or die('Error: ' . mysqli_error($mysqli));
            } else {
                $query = false;
            }
            ?>
            <div class="card mt-4">
                <div class="card-header">
                    <h2 class="h4">Resultados</h2>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">ID Ajuste</th>
                                <th class="text-center">Usuario</th>
                                <th class="text-center">Fecha</th>
                                <th class="text-center">Producto</th>
                                <th class="text-center">Deposito</th>
                                <th class="text-center">Cantidad Anterior</th>
                                <th class="text-center">Cantidad Ajustada</th>
                                <th class="text-center">Cantidad Final</th>
                                <th class="text-center">Motivo</th>
                                <th class="text-center">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($query) {
                                while ($data = mysqli_fetch_assoc($query)) {
                                    echo "<tr>
                                            <td class='text-center'>{$data['id_ajuste']}</td>
                                            <td class='text-center'>{$data['name_user']}</td>
                                            <td class='text-center'>{$data['fecha_ajuste']}</td>
                                            <td class='text-center'>{$data['p_descrip']}</td>
                                            <td class='text-center'>{$data['descrip']}</td>
                                            <td class='text-center'>{$data['cantidad_anterior']}</td>
                                            <td class='text-center'>{$data['cantidad_ajustada']}</td>";

                                    $cantidad_final = ($data['cantidad_anterior'] - $data['cantidad_ajustada']);

                                    echo "  <td class='text-center'>{$cantidad_final}</td>
                                            <td class='text-center'>{$data['motivo']}</td>
                                            <td class='text-center'>{$data['estado']}</td>
                                        </tr>";
                                }
                            } else {
                                echo "<tr>
                                        <td colspan='10' class='text-center'>No se encontraron resultados.</td>
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