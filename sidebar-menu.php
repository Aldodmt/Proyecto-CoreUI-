<div class="sidebar sidebar-narrow-unfoldable border-end">
  <div class="sidebar-header border-bottom">
    <div class="sidebar-brand"><img src="images/favicon.ico" alt="sysweb" height="25px"></div>
  </div>
  <ul class="sidebar-nav">
    <li class="nav-title">Menú</li>

    <?php
    // Definición del menú por roles
    $menu_items = [
        'Super Admin' => [
            ['module' => 'start', 'icon' => 'cil-home', 'label' => 'Inicio'],
            [
                'label' => 'Referenciales Generales',
                'icon' => 'cil-file',
                'dropdown' => [
                    ['module' => 'departamento', 'label' => 'Departamento'],
                    ['module' => 'ciudad', 'label' => 'Ciudad'],
                ],
            ],
            [
                'label' => 'Referenciales de Compra',
                'icon' => 'cil-file',
                'dropdown' => [
                    ['module' => 'deposito', 'label' => 'Depósito'],
                    ['module' => 'proveedor', 'label' => 'Proveedor'],
                    ['module' => 'producto', 'label' => 'Producto'],
                    ['module' => 'unidad_medida', 'label' => 'Unidad de Medida'],
                ],
            ],
            [
                'label' => 'Referenciales de Ventas',
                'icon' => 'cil-file',
                'dropdown' => [
                    ['module' => 'clientes', 'label' => 'Clientes'],
                ],
            ],
            ['module' => 'user', 'icon' => 'cil-user', 'label' => 'Administrar Usuarios'],
            ['module' => 'password', 'icon' => 'cil-lock-locked', 'label' => 'Cambiar Contraseña'],
        ],
        'Compras' => [
            ['module' => 'start', 'icon' => 'cil-home', 'label' => 'Inicio'],
            [
                'label' => 'Referenciales Generales',
                'icon' => 'cil-file',
                'dropdown' => [
                    ['module' => 'departamento', 'label' => 'Departamento'],
                    ['module' => 'ciudad', 'label' => 'Ciudad'],
                ],
            ],
            [
                'label' => 'Referenciales de Compra',
                'icon' => 'cil-file',
                'dropdown' => [
                    ['module' => 'deposito', 'label' => 'Depósito'],
                    ['module' => 'proveedor', 'label' => 'Proveedor'],
                    ['module' => 'producto', 'label' => 'Producto'],
                    ['module' => 'unidad_medida', 'label' => 'Unidad de Medida'],
                ],
            ],
            ['module' => 'password', 'icon' => 'cil-lock-locked', 'label' => 'Cambiar Contraseña'],
        ],
        'Ventas' => [
            ['module' => 'start', 'icon' => 'cil-home', 'label' => 'Inicio'],
            [
                'label' => 'Referenciales Generales',
                'icon' => 'cil-file',
                'dropdown' => [
                    ['module' => 'departamento', 'label' => 'Departamento'],
                    ['module' => 'ciudad', 'label' => 'Ciudad'],
                ],
            ],
            [
                'label' => 'Referenciales de Ventas',
                'icon' => 'cil-file',
                'dropdown' => [
                    ['module' => 'clientes', 'label' => 'Clientes'],
                ],
            ],
            ['module' => 'password', 'icon' => 'cil-lock-locked', 'label' => 'Cambiar Contraseña'],
        ],
    ];

    // Menú dinámico basado en permisos
    $current_access = $_SESSION['permisos_acceso'];

    if (isset($menu_items[$current_access])) {
        foreach ($menu_items[$current_access] as $item) {
            if (isset($item['dropdown'])) {
                echo "<li class='nav-item nav-group'>";
                echo "<a class='nav-link nav-group-toggle' href='javascript:void(0)'>";
                echo "<i class='nav-icon {$item['icon']}'></i> {$item['label']}</a>";
                echo "<ul class='nav-group-items'>";
                foreach ($item['dropdown'] as $dropdown_item) {
                    echo "<li class='nav-item'>";
                    echo "<a class='nav-link' href='?module={$dropdown_item['module']}'>";
                    echo "<span class='nav-icon'><span class='nav-icon-bullet'></span></span> {$dropdown_item['label']}</a>";
                    echo "</li>";
                }
                echo "</ul></li>";
            } else {
                $active_class = ($_GET['module'] == $item['module']) ? "active" : "";
                echo "<li class='nav-item $active_class'>";
                echo "<a class='nav-link' href='?module={$item['module']}'>";
                echo "<i class='nav-icon {$item['icon']}'></i> {$item['label']}</a>";
                echo "</li>";
            }
        }
    }
    ?>
  </ul>
</div>
