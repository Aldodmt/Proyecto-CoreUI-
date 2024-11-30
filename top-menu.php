<?php
include 'config/database.php';

$query = mysqli_query($mysqli, "SELECT id_user, name_user, foto, permisos_acceso FROM usuarios WHERE id_user = '$_SESSION[id_user]'") or die('error' . mysqli_error($mysqli));

$data = mysqli_fetch_array($query);
?>

<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="userDropdownMenu" role="button" data-coreui-toggle="dropdown"
        aria-expanded="false">
        <?php
        if ($data['foto'] == '') { ?>
            <img src="images/user/user-default.png" alt="imagen de usuario" class="avatar-img rounded-circle"
                style="width: 40px; height: 40px;">
        <?php } else { ?>
            <img src="images/user/<?php echo $data['foto']; ?>" alt="imagen de usuario" class="avatar-img rounded-circle"
                style="width: 40px; height: 40px;">
        <?php } ?>
        <span class="ms-2"><?php echo $data['name_user']; ?></span>
    </a>
    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdownMenu">
        <div class="dropdown-header text-center">
            <?php
            if ($data['foto'] == '') { ?>
                <img src="images/user/user-default.png" alt="imagen de usuario" class="avatar rounded-circle"
                    style="width: 80px; height: 80px;">
            <?php } else { ?>
                <img src="images/user/<?php echo $data['foto']; ?>" alt="imagen de usuario" class="avatar rounded-circle"
                    style="width: 80px; height: 80px;">
            <?php } ?>
            <p class="mt-2 mb-0">
                <?php echo $data['name_user']; ?>
            </p>
            <small><?php echo $data['permisos_acceso']; ?></small>
        </div>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="?module=perfil">
            <i class="cil-user me-2"></i> Perfil
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" data-coreui-toggle="modal" href="#dialog">
            <i class="cil-account-logout me-2"></i> Cerrar sesión
        </a>
    </div>
</li>