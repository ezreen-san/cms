<?php
session_start();

// Check if reset user ID is stored in session (user has verified OTP)
if (!isset($_SESSION['reset_user_id'])) {
    header("Location: forgot-password.php");
    exit;
}

$error_message = "";
$success_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $user_id = $_SESSION['reset_user_id'];
    
    // Validate password
    if (strlen($password) < 8) {
        $error_message = "Password must be at least 8 characters";
    } elseif (!preg_match("/[a-z]/i", $password)) {
        $error_message = "Password must contain at least one letter";
    } elseif (!preg_match("/[0-9]/", $password)) {
        $error_message = "Password must contain at least one number";
    } elseif ($password !== $confirm_password) {
        $error_message = "Passwords do not match";
    } else {
        // Hash the new password
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        
        require_once '../includes/db_connection.php';
        
        // Update the user's password and clear the reset token
        $stmt = $pdo->prepare("UPDATE users 
                              SET password = :password_hash, 
                                  reset_token_hash = NULL, 
                                  reset_token_expires_at = NULL 
                              WHERE id = :user_id");
        
        $stmt->execute([
            'password_hash' => $password_hash,
            'user_id' => $user_id
        ]);
        
        if ($stmt->rowCount() > 0) {
            $success_message = "Password has been reset successfully!";
            
            // Clear reset sessions
            unset($_SESSION['reset_email']);
            unset($_SESSION['reset_user_id']);
            
            // Show success message and redirect after a delay
            header("refresh:3;url=index.php");
        } else {
            $error_message = "Failed to update password. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | SCMS Breyer Gombak</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="container">
        <img src="../assets/img/logo.png" alt="Logo" class="logo">
        <div class="title-box">
            <h2>Reset Password</h2>
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
            <form action="" method="POST" class="registration-form">
                <div class="password-container">
                    <input type="password" placeholder="New Password" name="password" class="firstinput" required>
                    <i class="toggle-password fas fa-eye" onclick="togglePassword('password')"></i>
                </div>
                <div class="password-container">
                    <input type="password" placeholder="Confirm New Password" name="confirm_password" required>
                    <i class="toggle-password fas fa-eye" onclick="togglePassword('confirm_password')"></i>
                </div>
                <button type="submit">Reset Password</button>
            </form>
            <hr>
            <p class="existing">Remember your password?</p>
            <a class="sign_in" href="../index.php">Back to login</a>
        </div>
    </div>
    <script src="../assets/script/password-toggle.js"></script>
</body>
</html>