<?php
// Mostrar errores PHP (Desactivar en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir la libreria PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Inicio
$mail = new PHPMailer(true);

try {
    // Configuracion SMTP
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                         // Mostrar salida (Desactivar en producción)
    $mail->isSMTP();                                               // Activar envio SMTP
    $mail->Host = 'smtp.gmail.com';                         // Servidor SMTP
    $mail->SMTPAuth = true;                                       // Identificacion SMTP
    $mail->Username = 'aldo28071987@gmail.com';                             // Usuario SMTP
    $mail->Password = 'ctliypfzvalquetn';	                    // Contraseña SMTP
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->setFrom('Yo@gmail.com', 'Yo');                // Remitente del correo

    // Destinatarios
    $mail->addAddress('aldo28071987@gmail.com', 'Carlos gri');  // Email y nombre del destinatario

    // Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = 'Recuperacion de contraseña';
    $mail->Body = '<h1>Una carta de afecto para la linda Yani</h1>
    <p>Consegui que funcionara la Api despues de un rato de probar, te quiero mucho UwU<b>';
    //Lo de abajo dudo mucho que use pero si llego a usar es para cargar contenido por si el html no anda
    //$mail->AltBody = '';
    $mail->send();
    echo 'El mensaje se ha enviado';
} catch (Exception $e) {
    echo "El mensaje no se ha enviado. Mailer Error: {$mail->ErrorInfo}";
}