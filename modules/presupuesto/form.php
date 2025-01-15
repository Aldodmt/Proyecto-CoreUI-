<?php
if ($_GET['form'] == 'add') { ?>
    <div class="container-fluid">
        <div class="fade-in">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="?module=start"><i class="cil-home"></i> Inicio</a></li>
                        <li class="breadcrumb-item"><a href="?module=presupuesto">Presupuestos</a></li>
                        <li class="breadcrumb-item active">Agregar</li>
                    </ol>
                </div>
            </div>
            <div class="col-sm-6">
                <h1><i class="fa fa-edit icon-title"></i> Agregar Presupuesto</h1>
            </div>
            <div class="card">
                <div class="card-header"><strong>Formulario de Presupuestos</strong></div>
                <form action="modules/presupuesto/proses.php?act=insert" method="POST" class="form-horizontal"
                    id="formPresupuesto">
                    <div class="card-body">
                        <?php
                        // Generar código único
                        $query_id = mysqli_query($mysqli, "SELECT MAX(id_presupuesto) as id FROM presupuesto")
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
                            <label class="col-md-2 col-form-label">Fecha Emision</label>
                            <div class="col-md-2">
                                <input type="date" class="form-control" name="fecha_e" value="<?php echo date("Y-m-d"); ?>">
                            </div>

                            <label class="col-md-2 col-form-label">Fecha Vencimiento</label>
                            <div class="col-md-2">
                                <input type="date" class="form-control" name="fecha_v" value="<?php
                                echo date("Y-m-d");
                                ?>">
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
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

                        <div class="form-group">
                            <label class="col-md-2 col-form-label">Pedido</label>
                            <div class="col-md-10">
                                <button type="button" class="btn btn-info" data-coreui-toggle="modal"
                                    data-coreui-target="#myModal">
                                    <i class="fa fa-plus"></i> Buscar Pedido
                                </button>
                            </div>
                        </div>

                        <div id="resultados" class="mt-3"></div>
                        <input type="hidden" id="id_pedido" name="id_ped">

                        <br>
                        <div class="form-group">
                            <label class="col-md-2 col-form-label">Producto</label>
                            <div class="col-md-4">
                                <select class="form-control" name="codigo_producto">
                                    <option value="" disabled selected>-- Seleccionar Producto --</option>
                                    <?php
                                    if (isset($_POST['id_ped']) && is_numeric($_POST['id_ped'])) {
                                        echo $_POST['id_ped'];
                                        $id_ped = $_POST['id_ped'];
                                        //$id_ped = mysqli_real_escape_string($mysqli, $id_ped);
                                
                                        $query_prove = "SELECT cod_producto, p_descrip FROM v_pedido WHERE estado = 'aprobado' AND id_pedido = $id_ped ORDER BY cod_producto ASC";
                                        $result = mysqli_query($mysqli, $query_prove);

                                        if (!$result) {
                                            die("Error al ejecutar la consulta: " . mysqli_error($mysqli));
                                        }

                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<option value='{$row['cod_producto']}'>{$row['cod_producto']} || {$row['p_descrip']}</option>";
                                            }
                                        } else {
                                            echo "<option value='' disabled>No hay productos disponibles</option>";
                                        }
                                    } else {
                                        echo "<option value='' disabled>ID de pedido inválido</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <label class="col-md-2 col-form-label">Cantidad</label>
                            <div class="col-md-2">
                                <input type="number" class="form-control" name="cantidad_presu" id="cantidad">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 col-form-label">Precio Unitario</label>
                            <div class="col-md-2">
                                <input type="number" class="form-control" name="precio_unit" id="precio">
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <button type="button" class="btn btn-primary" onclick="agregarProducto()">Guardar</button>
                        </div>

                        <br>
                        <div class="form-group">
                            <table class="table table-bordered" id="tablaProductos">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Precio Unitario</th>
                                        <th>Subtotal</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Las filas se van a generar aca -->
                                </tbody>
                            </table>
                        </div>

                        <script>
                            function agregarProducto() {
                                const productoSelect = document.querySelector('select[name="codigo_producto"]');
                                const cantidadInput = document.getElementById('cantidad');
                                const precioInput = document.getElementById('precio');

                                const producto = productoSelect.options[productoSelect.selectedIndex].text;
                                const codigoProducto = productoSelect.value;
                                const cantidad = parseFloat(cantidadInput.value);
                                const precio = parseFloat(precioInput.value);
                                const subtotal = cantidad * precio;

                                if (!codigoProducto || isNaN(cantidad) || isNaN(precio)) {
                                    alert('Completa todos los campos antes de agregar un producto.');
                                    return;
                                }

                                const tbody = document.querySelector('#tablaProductos tbody');
                                const filas = tbody.querySelectorAll('tr');
                                // Validar si el producto ya está en la tabla
                                for (let fila of filas) {
                                    const codigoExistente = fila.querySelector('td').textContent.split(' || ')[0].trim();
                                    if (codigoExistente === codigoProducto) {
                                        alert('Este producto ya ha sido agregado. Por favor, selecciona otro producto.');
                                        return;
                                    }
                                }
                                const fila = `
                    <tr>
                    <td>${codigoProducto} || ${producto}</td>
                    <td>${cantidad}</td>
                    <td>${precio}</td>
                    <td>${subtotal}</td>
                    <td>
                    <button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(this)">
                    Eliminar
                    </button>
                    </td>
                    </tr>
                    `;
                                tbody.innerHTML += fila;

                                // Limpiar los campos después de agregar
                                productoSelect.selectedIndex = 0;
                                cantidadInput.value = '';
                                precioInput.value = '';
                            }
                            function eliminarFila(button) {
                                // Confirmar antes de eliminar
                                if (confirm('¿Estás seguro de que deseas eliminar este producto?')) {
                                    // Obtener la fila padre del botón y eliminarla
                                    const fila = button.closest('tr');
                                    fila.remove();

                                    // Opcional: Mostrar un mensaje de éxito
                                    alert('Producto eliminado de la tabla.');
                                }
                            }
                            document.getElementById('formPresupuesto').addEventListener('submit', function (event) {
                                // Serializar los datos de la tabla
                                const productos = [];
                                const filas = document.querySelectorAll('#tablaProductos tbody tr');

                                filas.forEach(fila => {
                                    const columnas = fila.querySelectorAll('td');
                                    productos.push({
                                        codigo_producto: columnas[0].textContent.trim(), // Columna Producto
                                        cantidad: parseFloat(columnas[1].textContent.trim()), // Columna Cantidad
                                        precio_unitario: parseFloat(columnas[2].textContent.trim()) // Columna Precio Unitario
                                    });
                                });

                                // Verificar si hay productos
                                if (productos.length === 0) {
                                    alert("Debes agregar al menos un producto antes de guardar.");
                                    event.preventDefault();
                                    return;
                                }

                                // Convertir los datos a JSON y asignarlos al campo oculto
                                document.getElementById('productos_json').value = JSON.stringify(productos);
                            });
                        </script>
                    </div>
                    <!-- recibe los datos del json -->
                    <input type="hidden" name="productos_json" id="productos_json">
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" name="Guardar">Guardar</button>
                        <a href="?module=presupuesto" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
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
            url: './ajax/productos_pedido_presu.php',
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
            url: "./ajax/agregar_pedido_presu.php",
            data: parametrosTabla,
            beforeSend: function () {
                $("#resultados").html("Cargando tabla...");
            },
            success: function (datos) {
                $("#resultados").html(datos);
            }
        });

        // Segundo paso: Llenar el combo box de productos
        var parametrosProductos = { "id_pedido": id };
        $.ajax({
            type: "POST",
            url: "modules/presupuesto/ajax/obtener_productos_pedido.php",
            data: parametrosProductos,
            beforeSend: function () {
                $("#resultados").html("Cargando productos...");
            },
            success: function (datos) {
                try {
                    var productos = JSON.parse(datos); // Parsear la respuesta JSON
                    var productoSelect = $('select[name="codigo_producto"]');
                    productoSelect.empty(); // Vaciar el combo box antes de llenarlo

                    if (productos.length > 0) {
                        // Si hay productos, llenarlos en el combo box
                        productoSelect.append('<option value="" disabled selected>-- Seleccionar Producto --</option>');
                        productos.forEach(function (producto) {
                            productoSelect.append('<option value="' + producto.cod_producto + '">' + producto.cod_producto + ' || ' + producto.p_descrip + '</option>');
                        });
                    } else {
                        productoSelect.append('<option value="" disabled>No hay productos disponibles</option>');
                    }
                } catch (e) {
                    alert("Error al procesar los datos: " + e.message);
                }
            },
            error: function () {
                alert("Hubo un error al cargar los productos.");
            }
        });
    }

    function eliminar(id) {
        $.ajax({
            type: "GET",
            url: "./ajax/agregar_pedido_presu.php",
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
                <h5 class="modal-title" id="myModallabel">Buscar Pedido</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="x" placeholder="Buscar pedido"
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