<?php
if ($_SESSION['permisos_acceso'] == 'Super Admin') { ?>
    <div class="d-flex justify-content-between align-items-center">
        <h1>
            <i class="cil-home icon-title"></i> Inicio
        </h1>
        <ol class="breadcrumb ms-auto">
            <li class="breadcrumb-item"><a href="?module=start"><i class="cil-home"></i></a></li>
        </ol>
    </div>
    <section class="content">
    <div class="row">
        <div class="col-lg-12 col-xs-12">
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
                <p style="font-size: 15px;">
                    <i class="cil-user"></i> Bienvenido/a <strong><?php echo $_SESSION['name_user']; ?></strong>
                </p>
            </div>
        </div>
    </div>


        <h2>Formulario de movimiento</h2>
        <div class="row">
            <!-- bloque 1 compras -->
            <div class="col-lg-4 col-xs-6">
                <div class="card text-white bg-secondary mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><strong>Compras</strong></h5>
                        <ul>
                            <li>Registrar</li>
                            <li>Compra</li>
                            <li>Productos</li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <a href="?module=compras" class="btn btn-light" title="Registrar compras" data-toggle="tooltip"><i
                                class="cil-plus"></i></a>
                    </div>
                </div>
            </div>
            <!-- fin bloque 1 compras -->

            <!-- bloque 2 ventas -->
            <div class="col-lg-4 col-xs-6">
                <div class="card text-white bg-info mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><strong>Ventas</strong></h5>
                        <ul>
                            <li>Registrar</li>
                            <li>Ventas</li>
                            <li>Productos</li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <a href="?module=ventas" class="btn btn-light" title="Registrar ventas" data-toggle="tooltip"><i
                                class="cil-plus"></i></a>
                    </div>
                </div>
            </div>
            <!-- fin bloque 2 ventas -->

            <!-- bloque 3 stock -->
            <div class="col-lg-4 col-xs-6">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><strong>Stock de productos</strong></h5>
                        <ul>
                            <li>Visualizar</li>
                            <li>Stock</li>
                            <li>Productos</li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <a href="?module=stock" class="btn btn-light" title="Ver stock de productos"
                            data-toggle="tooltip"><i class="cil-plus"></i></a>
                    </div>
                </div>
            </div>
            <!-- fin bloque 3 stock -->

            <div class="col-xl-6 col-lg-5">
                <div class="card no-shadow nb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"></div>
                </div>
            </div>

        </div>
    </section>
<?php } elseif ($_SESSION['permisos_acceso'] == 'Compras') { ?>
    <section class="content-header">
        <h1>
            <i class="cil-home icon-title"></i>Inicio
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="?module=start"><i class="cil-home"></i></a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
                    <p style="font-size: 15px;">
                        <i class="cil-user"></i> Bienvenido/a <strong><?php echo $_SESSION['name_user']; ?></strong>
                    </p>
                </div>
            </div>
        </div>

        <h2>Formulario de movimiento</h2>
        <div class="row">
            <!-- bloque 1 compras -->
            <div class="col-lg-4 col-xs-6">
                <div class="card text-white bg-secondary mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><strong>Compras</strong></h5>
                        <ul>
                            <li>Registrar</li>
                            <li>Compra</li>
                            <li>Productos</li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <a href="?module=compras" class="btn btn-light" title="Registrar compras" data-toggle="tooltip"><i
                                class="cil-plus"></i></a>
                    </div>
                </div>
            </div>
            <!-- fin bloque 1 compras -->

            <!-- bloque 3 stock -->
            <div class="col-lg-4 col-xs-6">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><strong>Stock de productos</strong></h5>
                        <ul>
                            <li>Visualizar</li>
                            <li>Stock</li>
                            <li>Productos</li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <a href="?module=stock" class="btn btn-light" title="Ver stock de productos"
                            data-toggle="tooltip"><i class="cil-plus"></i></a>
                    </div>
                </div>
            </div>
            <!-- fin bloque 3 stock -->

            <div class="col-xl-6 col-lg-5">
                <div class="card no-shadow nb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"></div>
                </div>
            </div>

        </div>
    </section>
<?php } elseif ($_SESSION['permisos_acceso'] == 'Ventas') { ?>
    <section class="content-header">
        <h1>
            <i class="cil-home icon-title"></i>Inicio
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="?module=start"><i class="cil-home"></i></a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
                    <p style="font-size: 15px;">
                        <i class="cil-user"></i> Bienvenido/a <strong><?php echo $_SESSION['name_user']; ?></strong>
                    </p>
                </div>
            </div>
        </div>

        <h2>Formulario de movimiento</h2>
        <div class="row">
            <!-- bloque 2 ventas -->
            <div class="col-lg-4 col-xs-6">
                <div class="card text-white bg-info mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><strong>Ventas</strong></h5>
                        <ul>
                            <li>Registrar</li>
                            <li>Ventas</li>
                            <li>Productos</li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <a href="?module=ventas" class="btn btn-light" title="Registrar ventas" data-toggle="tooltip"><i
                                class="cil-plus"></i></a>
                    </div>
                </div>
            </div>
            <!-- fin bloque 2 ventas -->

            <!-- bloque 3 stock -->
            <div class="col-lg -4 col-xs-6">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><strong>Stock de productos</strong></h5>
                        <ul>
                            <li>Visualizar</li>
                            <li>Stock</li>
                            <li>Productos</li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <a href="?module=stock" class="btn btn-light" title="Ver stock de productos"
                            data-toggle="tooltip"><i class="cil-plus"></i></a>
                    </div>
                </div>
            </div>
            <!-- fin bloque 3 stock -->

            <div class="col-xl-6 col-lg-5">
                <div class="card no-shadow nb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"></div>
                </div>
            </div>

        </div>
    </section>
<?php } ?>