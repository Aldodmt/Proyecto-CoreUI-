<?php
require_once '../config/database.php';
$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
if ($action == 'ajax') {
    $x = mysqli_real_escape_string($mysqli, (strip_tags($_REQUEST['x'], ENT_QUOTES)));
    $aColumns = array('id_orden_comp', 'id_presupuesto', 'name_user', 'fecha', 'hora', 'p_descrip', 'cantidad_aprobada', 'precio_unit', 'estado');
    $sTable = "v_orden_comp";
    $sWhere = "WHERE estado = 'aprobado' "; // Filtro por defecto para estado aprobado


    // Excluir ordenes de compra que ya existan en la tabla de compra
    $sWhere .= "AND id_orden_comp NOT IN (SELECT id_orden_comp FROM compra) ";

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
                        <th class="text-center">ID</th>
                        <th class="text-center">ID presupuesto</th>
                        <th class="text-center">Usuario</th>
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
                        $cod = $data['id_orden_comp'];
                        $cod_p = $data['id_presupuesto'];
                        $usuario = $data['name_user'];
                        $fecha = $data['fecha'];
                        $hora = $data['hora'];
                        $prod = $data['p_descrip'];
                        $cantidad = $data['cantidad_aprobada'];
                        $precio = $data['precio_unit'];
                        $total = ($data['cantidad_aprobada'] * $data['precio_unit']);
                        $estado = $data['estado']; ?>
                        <tr>
                            <td><?php echo $cod; ?></td>
                            <td><?php echo $cod_p; ?></td>
                            <td><?php echo $usuario; ?></td>
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