<?php
if ($_GET['form'] == 'add') { ?>
    <div class="container-fluid">
        <div class="fade-in">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="?module=start"><i class="cil-home"></i> Inicio</a></li>
                        <li class="breadcrumb-item"><a href="?module=compras">Compra</a></li>
                        <li class="breadcrumb-item active">Agregar</li>
                    </ol>
                </div>
            </div>
            <div class="col-sm-6">
                <h1><i class="fa fa-edit icon-title"></i> Agregar de compra</h1>
            </div>
            <div class="card">
                <div class="card-header"><strong>Formulario de compra</strong></div>
                <form action="modules/compras/proses.php?act=insert" method="POST" class="form-horizontal"
                    id="formPresupuesto">
                    <div class="card-body">
                        <?php
                        // Generar código único
                        $query_id = mysqli_query($mysqli, "SELECT MAX(cod_compra) as id FROM compra")
                            or die("Error: " . mysqli_error($mysqli));
                        $data_id = mysqli_fetch_assoc($query_id);
                        $codigo = $data_id['id'] + 1 ?? 1;
                        ?>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Código</label>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="codigo" value="<?php echo $codigo; ?>"
                                    readonly>
                            </div>
                            <label class="col-md-2 col-form-label">Fecha</label>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="fecha" value="<?php echo date("Y-m-d"); ?>"
                                    readonly>
                            </div>
                            <label class="col-md-2 col-form-label">Hora</label>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="hora" value="<?php echo date("H:i:s"); ?>"
                                    readonly>
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">N° de Factura</label>
                            <div class="col-md-4">
                                <input class="form-control" type="text" id="nro_factura" name="nro_factura"
                                    placeholder="000-000-001" maxlength="11">
                            </div>
                            <label class="col-md-2 col-form-label">Proveedor</label>
                            <div class="col-md-4">
                                <select class="form-control" name="codigo_proveedor" required>
                                    <option value="" disabled selected>-- Seleccionar Proveedor --</option>
                                    <?php
                                    $query_prove = mysqli_query($mysqli, "SELECT cod_proveedor, razon_social FROM proveedor ORDER BY razon_social ASC")
                                        or die("Error: " . mysqli_error($mysqli));
                                    while ($row = mysqli_fetch_assoc($query_prove)) {
                                        echo "<option value='{$row['cod_proveedor']}'>{$row['razon_social']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>


                        </div>
                        <br>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">N° de Timbrado</label>
                            <div class="col-md-4">
                                <input class="form-control" type="text" name="nro_timbrado" placeholder="12345678">
                            </div>
                            <label class="col-md-2 col-form-label">Deposito</label>
                            <div class="col-md-4">
                                <select class="form-control" name="codigo_deposito" required>
                                    <option value="" disabled selected>-- Seleccionar Depósito --</option>
                                    <?php
                                    $query_dep = mysqli_query($mysqli, "SELECT cod_deposito, descrip FROM deposito ORDER BY descrip ASC")
                                        or die("Error: " . mysqli_error($mysqli));
                                    while ($row = mysqli_fetch_assoc($query_dep)) {
                                        echo "<option value='{$row['cod_deposito']}'>{$row['descrip']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                        </div>
                        <br>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Timbrado vencimiento</label>
                            <div class="col-md-2">
                                <input type="date" class="form-control" name="timbrado_vencimiento"
                                    value="<?php echo date("Y-m-d"); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 col-form-label">Orden de compra</label>
                            <div class="col-md-10">
                                <button type="button" class="btn btn-info" data-coreui-toggle="modal"
                                    data-coreui-target="#myModal">
                                    <i class="fa fa-plus"></i> Buscar orden de compra
                                </button>
                            </div>
                        </div>
                        <div id="resultados" class="mt-3"></div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" name="Guardar">Guardar</button>
                            <a href="?module=compras" class="btn btn-secondary">Cancelar</a>
                        </div>
                </form>
                <script>
                    document.getElementById('nro_factura').addEventListener('input', function (e) {
                        const input = e.target;
                        let value = input.value.replace(/\D/g, '');

                        if (value.length > 3) {
                            value = value.substring(0, 3) + '-' + value.substring(3);
                        }
                        if (value.length > 7) {
                            value = value.substring(0, 7) + '-' + value.substring(7);
                        }
                        if (value.length > 11) {
                            value = value.substring(0, 11);
                        }

                        input.value = value;
                    });
                </script>
            </div>
        </div>
    </div>
<?php } ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">

<script>
    $(document).ready(function () {
        load(1);
    });

    function load(page) {
        var x = $("#x").val();
        var parametros = { "action": "ajax", "page": page, "x": x };
        $("#loader").fadeIn('slow');
        $.ajax({
            url: './ajax/productos_pedido_compra.php',
            data: parametros,
            beforeSend: function (objeto) {
                $('#loader').html('<img src="./images/ajax-loader.gif">Cargando....');
            },
            success: function (data) {
                $(".outer_div").html(data).fadeIn('slow');
                $('#loader').html('');
            }
        });
    }

    function agregar(id) {
        var parametrosTabla = { "id": id };
        $.ajax({
            type: "POST",
            url: "./ajax/agregar_pedido_compra.php",
            data: parametrosTabla,
            beforeSend: function () {
                $("#resultados").html("Cargando tabla...");
            },
            success: function (datos) {
                $("#resultados").html(datos);
            }
        });
    }

    function eliminar(id) {
        $.ajax({
            type: "GET",
            url: "./ajax/agregar_pedido_compra.php",
            data: "id=" + id,
            beforeSend: function (objeto) {
                $("#resultados").html("Mensaje: cargando...");
            },
            success: function (datos) {
                $("#resultados").html(datos);
            }
        });
    }
</script>

<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModallabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModallabel">Buscar Orden</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="x" placeholder="Buscar orden de compra"
                                onkeyup="load(1)">
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-primary" onclick="load(1)">
                                <i class="cil-search"></i> Buscar
                            </button>
                        </div>
                    </div>
                </form>
                <div id="loader" class="text-center d-none">
                    <img src="./images/ajax-loader.gif" alt="Cargando..." /> Cargando...
                </div>
                <div class="outer_div"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>