<?php
require_once '../config/database.php';
$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
if ($action == 'ajax') {
    $x = mysqli_real_escape_string($mysqli, (strip_tags($_REQUEST['x'], ENT_QUOTES)));
    $aColumns = array('cod_compra', 'name_user', 'fecha', 'hora', 'id_orden_comp', 'razon_social', 'descrip', 'nro_factura', 'p_descrip', 'cantidad', 'precio', 'estado');
    $sTable = "v_compras";
    $sWhere = "WHERE estado = 'activo' "; // Filtro por defecto para estado aprobado

    // Excluir ordenes de compra que ya existan en la tabla de compra
    $sWhere .= "AND cod_compra NOT IN (SELECT cod_compra FROM nota_credito_debito) ";

    if (!empty($_GET['x'])) {
        $sWhere .= "AND ("; // Añadir búsqueda dinámica
        for ($i = 0; $i < count($aColumns); $i++) {
            $sWhere .= $aColumns[$i] . " LIKE '%" . $x . "%' OR ";
        }
        $sWhere = substr_replace($sWhere, "", -3);
        $sWhere .= ")";
    }

    // Paginación
    include 'paginacion.php';
    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page = 5;
    $adjacents = 4;
    $offset = ($page - 1) * $per_page;

    $count_query = mysqli_query($mysqli, "SELECT count(*) AS numeros FROM $sTable $sWhere");
    $row = mysqli_fetch_assoc($count_query);
    $numeros = $row['numeros'];
    $total_pages = ceil($numeros / $per_page);
    $reload = './index.php';

    $sql = "SELECT * FROM $sTable $sWhere LIMIT $offset, $per_page";
    $query = mysqli_query($mysqli, $sql);

    if ($numeros > 0) { ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-primary">
                    <tr>
                        <th class="text-center">ID compra</th>
                        <th class="text-center">ID orden compra</th>
                        <th class="text-center">Usuario</th>
                        <th class="text-center">Proveedor</th>
                        <th class="text-center">Deposito</th>
                        <th class="text-center">Fecha</th>
                        <th class="text-center">Hora</th>
                        <th class="text-center">Producto</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-center">Precio Unitario</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">Estado</th>
                        <th style="width:36px;">Seleccion</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($data = mysqli_fetch_assoc($query)) {
                        $cod = $data['cod_compra'];
                        $cod_o = $data['id_orden_comp'];
                        $razon = $data['razon_social'];
                        $usu = $data['name_user'];
                        $fecha = $data['fecha'];
                        $hora = $data['hora'];
                        $prod = $data['p_descrip'];
                        $depo = $data['descrip'];
                        $cantidad = $data['cantidad'];
                        $precio = $data['precio'];
                        $total = ($data['cantidad'] * $data['precio']);
                        $estado = $data['estado']; ?>
                        <tr>
                            <td><?php echo $cod; ?></td>
                            <td><?php echo $cod_o; ?></td>
                            <td><?php echo $usu; ?></td>
                            <td><?php echo $razon; ?></td>
                            <td><?php echo $depo; ?></td>
                            <td><?php echo $fecha; ?></td>
                            <td><?php echo $hora; ?></td>
                            <td><?php echo $prod; ?></td>
                            <td><?php echo $cantidad; ?></td>
                            <td><?php echo $precio; ?></td>
                            <td><?php echo $total; ?></td>
                            <td><?php echo $estado; ?></td>
                            <td>
                                <button class="btn btn-success btn-sm" onclick="agregar('<?php echo $cod; ?>')">
                                    <i class="cil-plus"></i>
                                </button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="7">
                            <nav aria-label="Page navigation">
                                <?php echo paginate($reload, $page, $total_pages, $adjacents); ?>
                            </nav>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    <?php }
}
?>