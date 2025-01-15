<?php
    if($_GET['form']=='add'){ ?>
        <section class="content-header">
            <h1>
                <i class="cil-pencil icon-title"></i> Agregar proveedor
            </h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="?module=start"><i class="cil-home"></i> Inicio</a></li>
                <li class="breadcrumb-item"><a href="?module=proveedor">Proveedores</a></li>
                <li class="breadcrumb-item active">Agregar</li>
            </ol>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form role="form" class="form-horizontal" action="modules/proveedor/process.php?act=insert" method="POST">
                            <div class="card-body">
                                <?php
                                // Generación del código
                                    $query_id = mysqli_query($mysqli, "SELECT MAX(cod_proveedor) as id FROM proveedor") or die('error'.mysqli_error($mysqli));
                                    $count = mysqli_num_rows($query_id);
                                    if($count <> 0){
                                        $data_id = mysqli_fetch_assoc($query_id);
                                        $codigo = $data_id['id'] + 1;
                                    }else{
                                        $codigo = 1;
                                    }
                                ?>
                                <div class="form-group">
                                    <label class="col-form-label">Código</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="codigo" value="<?php echo $codigo; ?>" readonly>
                                    </div>
                                </div>
                                 
                                <div class="form-group">
                                    <label class="col-form-label">Razón Social</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="razon_social" placeholder="Ingrese la razón social" autocomplete="off" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">RUC</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="ruc" placeholder="Ingrese el RUC" onkeypress="return goodchars(event, '0123456789', this)" autocomplete="off" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">Dirección</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="direccion" placeholder="Ingrese la dirección" autocomplete="off" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">Teléfono</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="telefono" placeholder="Ingrese su número de teléfono" autocomplete="off" onkeypress="return goodchars(event, '0123456789', this)">
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <input type="submit" class="btn btn-primary" name="Guardar" value="Guardar">
                                            <a href="?module=proveedor" class="btn btn-secondary">Cancelar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    <?php }
    elseif($_GET['form']=='edit'){
        if(isset($_GET['id'])){
            $query = mysqli_query($mysqli, "SELECT *FROM proveedor WHERE cod_proveedor = '$_GET[id]'") or die('error'.mysqli_error($mysqli));
            $data = mysqli_fetch_assoc($query);
        } ?>
        <section class="content-header">
            <h1>
                <i class="cil-pencil icon-title"></i> Modificar proveedor
            </h1>
            <ol class="breadcrumb">
                <li><a href="?module=start"><i class="cil-home"></i> Inicio</a></li>
                <li><a href="?module=proveedor">Proveedores</a></li>
                <li class="active">Modificar</li>
            </ol>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form role="form" class="form-horizontal" action="modules/proveedor/process.php?act=update" method="POST">
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="col-form-label">Código</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="codigo" value="<?php echo $data['cod_proveedor'] ?>" readonly>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">Razón Social</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="razon_social" value="<?php echo $data['razon_social']; ?>" autocomplete="off" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">RUC</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="ruc" value="<?php echo $data['ruc']; ?>" onkeypress="return goodchars(event, '0123456789', this)" autocomplete="off" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">Dirección</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="direccion" value="<?php echo $data['direccion']; ?>" autocomplete="off" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">Teléfono</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="telefono" value="<?php echo $data['telefono']; ?>" autocomplete="off" onkeypress="return goodchars(event, '0123456789', this)">
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <input type="submit" class="btn btn-primary" name="Guardar" value="Guardar">
                                            <a href="?module=proveedor" class="btn btn-secondary">Cancelar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    <?php }
