<?php
// Incluir archivo de configuración de base de datos
require_once "config/database.php";

// Capturar y limpiar los datos enviados desde el formulario
$username = mysqli_real_escape_string($mysqli, stripslashes(strip_tags(htmlspecialchars(trim($_POST['username'])))));
$password = mysqli_real_escape_string($mysqli, stripslashes(strip_tags(htmlspecialchars(trim($_POST['password'])))));

// Validar que los campos no contengan caracteres inválidos
if (!ctype_alnum($username) || !ctype_alnum($password)) {
    header("Location: index.php?alert=1"); // Error de credenciales
    exit();
}

// Convertir la contraseña a MD5 (para compatibilidad con sistemas existentes, aunque se recomienda un hash más seguro como bcrypt)
$password = md5($password);

// Consultar la base de datos para verificar las credenciales
$query = mysqli_query($mysqli, "SELECT * FROM usuarios WHERE username = '$username' AND password = '$password' AND status = 'activo'")
    or die('Error al realizar la consulta: ' . mysqli_error($mysql));

// Verificar si las credenciales son correctas
if (mysqli_num_rows($query) > 0) {
    // Obtener los datos del usuario
    $data = mysqli_fetch_assoc($query);

    // Iniciar sesión
    session_start();
    $_SESSION['id_user'] = $data['id_user'];
    $_SESSION['username'] = $data['username'];
    $_SESSION['password'] = $data['password']; // Esto no es recomendable, pero manteniendo el original
    $_SESSION['name_user'] = $data['name_user'];
    $_SESSION['permisos_acceso'] = $data['permisos_acceso'];

    // Redirigir al inicio
    header("Location: main.php?module=start");
} else {
    // Redirigir al login con alerta de error
    header("Location: index.php?alert=1");
}
?>