<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | SCMS Breyer Gombak</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/styles.css">
</head>
<body>
    <div class="container">
        <img src="../../assets/img/logo.png" alt="Logo" class="logo">
        <div class="title-box">
            <h2>Forgot Password</h2>
        </div>
        <div class="message-box" id="message-box">
            <?php if (isset($_SESSION['error_message'])): ?>
                <p class="errormsg"><?php echo htmlspecialchars($_SESSION['error_message']); ?></p>
                <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>
        </div>
        <div class="main-box">
            <form action="send-password-reset.php" method="POST" class="registration-form">
                <input type="email" placeholder="Email Address" name="email" class="firstinput" required>
                <button type="submit">Request Password Reset</button>
            </form>
            <hr>
            <p class="existing">Remember your password?</p>
            <a class="sign_in" href="../../index.php">Back to login</a>
        </div>
    </div>
</body>
</html>