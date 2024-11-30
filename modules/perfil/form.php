<?php
if (isset($_POST['id_user'])) {
    $query = mysqli_query($mysqli, "SELECT *FROM usuarios WHERE id_user = $_POST[id_user]")
        or die(mysqli_error($mysqli));
    $data = mysqli_fetch_assoc($query);
}
?>

<section class="content-header">
    <h1>
        <i class="cil-pencil icon-title"></i>Modificar perfil de usuario
    </h1>
    <ol class="breadcrumb">
        <li><a href="?module=start"><i class="cil-home"></i>Inicio</a></li>
        <li><a href="?module=perfil">Perfil de usuario</a></li>
        <li class="active">Modificar</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Modificar datos del perfil</h4>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" method="POST" action="modules/perfil/proses.php?act=update"
                        enctype="multipart/form-data">
                        <input type="hidden" name="id_user" value="<?php echo $data['id_user']; ?>">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nombre de usuario</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="username" autocomplete="off"
                                    value="<?php echo $data['username'] ?>" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nombre y apellido</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="name_user" autocomplete="off"
                                    value="<?php echo $data['name_user'] ?>" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="email" autocomplete="off"
                                    value="<?php echo $data['email'] ?>" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Teléfono</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="telefono" autocomplete="off"
                                    value="<?php echo $data['telefono'] ?>" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Foto</label>
                            <div class="col-sm-5">
                                <input type="file" name="foto">
                                <br>
                                <?php
                                if ($data['foto'] == "") { ?>
                                    <img style="border:1px solid #eaeaea; border-radius:5px;"
                                        src="images/user/user-default.png" width="75" height="50">
                                <?php } else { ?>
                                    <img style="border:1px solid #eaeaea; border-radius:5px;"
                                        src="images/user/<?php echo $data['foto']; ?>" width="75" height="50">
                                <?php }
                                ?>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-footer">
                    <div class="form-group row">
                        <div class="col-sm-10 offset-sm-2">
                            <button type="submit" class="btn btn-primary" name="Guardar">Guardar</button>
                            <a href="?module=perfil" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>