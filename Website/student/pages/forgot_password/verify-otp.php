<?php
session_start();

// Check if reset email is stored in session
if (!isset($_SESSION['reset_email'])) {
    header("Location: forgot-password.php");
    exit;
}

$error_message = "";
$success_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $otp = $_POST['otp'];
    $email = $_SESSION['reset_email'];
    
    // Validate OTP
    $token_hash = hash("sha256", $otp);
    
    require_once '../../includes/db_connection.php';
    
    $stmt = $pdo->prepare("SELECT * FROM users 
                          WHERE email = :email 
                          AND reset_token_hash = :token_hash");
    
    $stmt->execute([
        'email' => $email,
        'token_hash' => $token_hash
    ]);
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        $error_message = "Invalid OTP. Please try again.";
    } else {
        // Check if token has expired
        if (strtotime($user['reset_token_expires_at']) <= time()) {
            $error_message = "OTP has expired. Please request a new one.";
        } else {
            // OTP is valid, store user ID in session and proceed to reset password
            $_SESSION['reset_user_id'] = $user['id'];
            header("Location: reset-password.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP | SCMS Breyer Gombak</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <style>
        .otp-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        .otp-input {
            width: 100%;
            padding: 10px;
            text-align: center;
            font-size: 16px;
            letter-spacing: 2px;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="../../assets/img/logo.png" alt="Logo" class="logo">
        <div class="title-box">
            <h2>Verify OTP</h2>
        </div>
        <div class="message-box">
            <?php if (!empty($error_message)): ?>
                <p class="errormsg"><?php echo htmlspecialchars($error_message); ?></p>
            <?php endif; ?>
            <?php if (!empty($success_message)): ?>
                <p class="successmsg"><?php echo htmlspecialchars($success_message); ?></p>
            <?php endif; ?>
        </div>
        <div class="main-box">
            <p style="
            margin-top: 0px;
            margin-bottom: 20px;
            ">Enter the 6-digit OTP sent to your email address.</p>
            <form action="" method="POST" class="registration-form">
                <input type="text" name="otp" class="otp-input firstinput" maxlength="6" placeholder="Enter 6-digit OTP" required>
                <button type="submit">Verify OTP</button>
            </form>
            <hr>
            <p class="existing">Didn't receive the OTP?</p>
            <a class="sign_in" href="forgot-password.php">Resend OTP</a>
        </div>
    </div>
</body>
</html>