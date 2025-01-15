<?php
require "../../config/database.php";

if (isset($_POST['Guardar'])) {
    $email = mysqli_real_escape_string($mysqli, trim($_POST['email']));
    $nuevo = mysqli_real_escape_string($mysqli, trim($_POST['nuevo']));
    $repetir = mysqli_real_escape_string($mysqli, trim($_POST['repetir']));

    // Verificar si el correo existe en la base de datos
    $query = mysqli_query($mysqli, "SELECT * FROM usuarios WHERE email = '$email'") or die("Error: " . mysqli_error($mysqli));
    // Validar que las contraseñas coincidan
    if ($nuevo !== $repetir) {
        header("Location: nueva_contra.php?email=$email&alert=1");
        exit;
    }

    // Actualizar la contraseña
    $new_pass = md5($nuevo); // Cambia a password_hash si puedes
    $update = mysqli_query($mysqli, "UPDATE usuarios SET password = '$new_pass' WHERE email = '$email'") or die("Error: " . mysqli_error($mysqli));
    if ($update) {
        header("Location: ../../index.php?alert=4");
    } else {
        header("Location: ../../index.php?alert=5");
    }
}
?>