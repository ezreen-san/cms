<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require __DIR__ . '/../forgot_password/vendor/autoload.php';

// Create a new PHPMailer instance
$mail = new PHPMailer(true);

// Server settings
// $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output
$mail->isSMTP();
$mail->Host = 'sandbox.smtp.mailtrap.io'; // Change to your SMTP server
$mail->SMTPAuth = true;
$mail->Username = 'b1d1c8e5c12644'; // Change to your email
$mail->Password = '78a4d34846a49c'; // Change to your password
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;

// Default sender
$mail->setFrom('no-reply@breyer.edu.my', 'Breyer College');

// Enable HTML
$mail->isHtml(true);

return $mail;