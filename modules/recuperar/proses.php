<?php
ob_start(); // Inicia el búfer de salida
require_once "../../config/database.php";

// Configurar la codificación UTF-8 
header('Content-Type: text/html; charset=utf-8');
// Incluir la librería PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../../PHPMailer/src/Exception.php';
require '../../PHPMailer/src/PHPMailer.php';
require '../../PHPMailer/src/SMTP.php';

if (isset($_POST['recuperar'])) {
    // Escapar el correo ingresado por el usuario y configurar UTF-8
    $email = htmlspecialchars(trim($_POST['email']), ENT_QUOTES, 'UTF-8');

    // Validar si el correo existe en la base de datos
    $query = mysqli_prepare($mysqli, "SELECT COUNT(*) FROM usuarios WHERE email = ?");
    mysqli_stmt_bind_param($query, "s", $email);
    mysqli_stmt_execute($query);
    mysqli_stmt_bind_result($query, $exists);
    mysqli_stmt_fetch($query);
    mysqli_stmt_close($query);

    if ($exists > 0) {
        // Preparar y enviar el correo con PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Configuración SMTP
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER; // Activar para depuración
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'aldo28071987@gmail.com'; // Tu correo
            $mail->Password = 'ctliypfzvalquetn'; // Contraseña de aplicación SMTP
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Remitente del correo
            $mail->setFrom('aldo28071987@gmail.com', 'Recuperación de Contraseña');
            $mail->CharSet = 'UTF-8'; // Configuración UTF-8 para PHPMailer

            // Destinatario: el correo proporcionado por el usuario
            $mail->addAddress($email);

            // Enlace de recuperación con el correo como parámetro
            $recovery_link = "http://localhost/Proyecto1/modules/recuperar/nueva_contra.php?email=" . urlencode($email);

            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = 'Recuperación de contraseña';
            $mail->Body = "
                <h1>Recuperación de contraseña</h1>
                <p>Estimado usuario, haga clic en el siguiente enlace para restablecer su contraseña:</p>
                <p><a href='$recovery_link' target='_blank'>Restablecer contraseña</a></p>
                <p>En caso de problemas, comuníquese con soporte técnico.
                <p>Aldo David Marin Torres</p>
                <p>Numero: 0987264101</p>
            ";

            $mail->send(); // Envía el correo

            // Redirigir al usuario con una alerta de éxito
            header("Location: /Proyecto1/modules/recuperar/recuperar.php?module=recuperar&alert=1");
        } catch (Exception $e) {
            // Manejo de errores en caso de que el correo no se envíe
            echo "No se pudo enviar el correo. Error: {$mail->ErrorInfo}";
        }
    } else {
        // Redirigir con una alerta indicando que el correo no existe
        header("Location: /Proyecto1/modules/recuperar/recuperar.php?module=recuperar&alert=2");
    }

    exit(); // Finaliza el script después de enviar el correo o redireccionar
}

ob_end_flush(); // Libera el búfer y envía todo al navegador
