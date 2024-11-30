<?php
if (isset($_SESSION['id_user'])) {
    $query = mysqli_query($mysqli, "SELECT *FROM usuarios WHERE id_user='$_SESSION[id_user]'")
        or die('error' . mysqli_error($mysqli));

    $data = mysqli_fetch_assoc($query);
}
?>

<section class="content-header">
    <h1>
        <i class="cil-user icon-title"></i>Perfil de usuario
    </h1>
    <ol class="breadcrumb">
        <li><a href="?module=start"><i class="cil-home"></i>Inicio</a></li>
        <li class="active">Perfil de usuario</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">

            <?php
            if (empty($_GET['alert'])) {
                echo '';
            } elseif ($_GET['alert'] == 1) {
                echo "<div class='alert alert-success alert-dismissible fade show'>
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>&times;</button>
                        <h4><i class='cil-check-circle'></i>Exitoso!</h4>
                        Los datos de usuario se han editado correctamente.
                    </div>";
            } elseif ($_GET['alert'] == 2) {
                echo "<div class='alert alert-danger alert-dismissible fade show'>
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>&times;</button>
                        <h4><i class='cil-x-circle'></i>Error!</h4>
                        Asegure de que la imagen es del formato indicado.
                    </div>";
            } elseif ($_GET['alert'] == 3) {
                echo "<div class='alert alert-danger alert-dismissible fade show'>
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>&times;</button>
                        <h4><i class='cil-x-circle'></i>Error!</h4>
                        El archivo debe de ser menor a 1 MB.
                    </div>";
            } elseif ($_GET['alert'] == 4) {
                echo "<div class='alert alert-danger alert-dismissible fade show'>
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>&times;</button>
                        <h4><i class='cil-x-circle'></i>Error!</h4>
                        Asegurese de que el tipo de archivo es: *.JPG *.JPEG *.PNG.
                    </div>";
            }
            ?>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Detalles de Perfil</h4>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" role="form" method="POST" action="?module=form_perfil"
                        enctype="multipart/form-data">
                        <input type="hidden" name="id_user" value="<?php echo $data['id_user'] ?>">

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Foto</label>
                            <div class="col-sm-10">
                                <?php if ($data['foto'] == '') { ?>
                                    <img style="border:1px solid #eaeaea; border-radius:50%;"
                                        src="images/user/user-default.png" width="75">
                                <?php } else { ?>
                                    <img style="border:1px solid #eaeaea; border-radius:50%;"
                                        src="images/user/<?php echo $data['foto']; ?>" width="75">
                                <?php } ?>
                            </div>
                        </div>

                        <hr>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nombre de usuario</label>
                            <div class="col-sm-10">
                                <p class="form-control-plaintext"><?php echo $data['username'] ?></p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <p class="form-control-plaintext"><?php echo $data['email'] ?></p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Teléfono</label>
                            <div class="col-sm-10">
                                <p class="form-control-plaintext"><?php echo $data['telefono'] ?></p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Permisos de acceso</label>
                            <div class="col-sm-10">
                                <p class="form-control-plaintext"><?php echo $data['permisos_acceso'] ?></p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Status</label>
                            <div class="col-sm-10">
                                <p class="form-control-plaintext"><?php echo $data['status'] ?></p>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="card-footer">
                    <form method="POST" action="?module=form_perfil" enctype="multipart/form-data">
                        <div class="form-group row">
                            <div class="col-sm-10 offset-sm-2">
                                <button type="submit" class="btn btn-primary" name="Guardar">Modificar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>