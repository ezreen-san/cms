<?php
session_start();
require_once '../includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
    
    if (!$email) {
        $_SESSION['error_message'] = "Please enter a valid email address.";
        header("Location: forgot-password.php");
        exit;
    }
    
    // Check if email exists in the database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        $_SESSION['error_message'] = "No account found with that email address.";
        header("Location: forgot-password.php");
        exit;
    }
    
    // Generate OTP (6-digit)
    $otp = sprintf("%06d", mt_rand(1, 999999));
    
    // Create a token hash
    $token_hash = hash("sha256", $otp);
    
    // Set token expiry (30 minutes from now)
    $expiry = date("Y-m-d H:i:s", time() + 60 * 30);
    
    // Update database with reset token
    $stmt = $pdo->prepare("UPDATE users 
                          SET reset_token_hash = :token_hash, 
                              reset_token_expires_at = :expiry 
                          WHERE email = :email");
    
    $stmt->execute([
        'token_hash' => $token_hash,
        'expiry' => $expiry,
        'email' => $email
    ]);
    
    if ($stmt->rowCount() > 0) {
        try {
            // Set up mailer
            $mail = require __DIR__ . "/../includes/mailer.php";
            
            $mail->addAddress($email);
            $mail->Subject = "Password Reset OTP - Breyer College";
            
            // Email body with OTP
            $mail->Body = <<<HTML
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                    .header { background: #004aad; color: white; padding: 10px; text-align: center; }
                    .content { padding: 20px; border: 1px solid #ddd; }
                    .otp { font-size: 24px; font-weight: bold; text-align: center; margin: 20px 0; letter-spacing: 5px; }
                    .footer { font-size: 12px; color: #666; margin-top: 20px; }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="header">
                        <h2>Breyer College Password Reset</h2>
                    </div>
                    <div class="content">
                        <p>Dear Student,</p>
                        <p>You have requested to reset your password. Please use the following One-Time Password (OTP) to complete the process:</p>
                        <div class="otp">$otp</div>
                        <p>This OTP will expire in 30 minutes.</p>
                        <p>If you did not request this password reset, please ignore this email or contact support.</p>
                    </div>
                    <div class="footer">
                        <p>This is an automated email. Please do not reply.</p>
                        <p>&copy; Breyer College. All rights reserved.</p>
                    </div>
                </div>
            </body>
            </html>
            HTML;
            
            $mail->send();
            
            // Redirect to OTP verification page with email in the session
            $_SESSION['reset_email'] = $email;
            header("Location: verify-otp.php");
            exit;
            
        } catch (Exception $e) {
            echo "Email could not be sent. Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Database update failed.";
    }
} else {
    header("Location: forgot-password.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sending Reset Email | SCMS Breyer Gombak</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="container">
        <img src="../assets/img/logo.png" alt="Logo" class="logo">
        <div class="title-box">
            <h2>Processing Request</h2>
        </div>
        <div class="main-box">
            <p>Processing your request. If you're not redirected within a few seconds, 
            <a href="forgot-password.php">click here</a> to try again.</p>
        </div>
    </div>
</body>
</html>