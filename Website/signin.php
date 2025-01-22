<?php
session_start();
include("db_connection.php");

$error_message = ""; // Initialize an empty error message

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['login'] = $username;
        $_SESSION['id'] = $user['id'];
        $userip = $_SERVER['REMOTE_ADDR'];
        $status = 1;

        header("Location: dashboard.php");
        exit();
    } else {
        $error_message = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SCMS | Breyer Gombak</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="login.css">
</head>
<body>
        <header class="logo-section">
            <img src="logo.png" alt="Breyer Logo" class="logo">
        </header>
    <div id="login-form" class="container">

    <h1 class="boxlabel">STUDENT LOGIN</h1>
    <div class="blue-part"></div>

            <?php if (!empty($error_message)): ?>
                    <p class="errormsg"><?php echo htmlspecialchars($error_message); ?></p>
            <?php endif; ?>

            <form action="" method="POST" class="registration-form" id="loginForm">
                <input type="text" id="username" name="username" class="firstinput" placeholder="Username" required>
                <input style="margin-bottom: 0px;" type="password" id="password" name="password" placeholder="Password" required>
            <div class="login-options">
                <input type="checkbox" value="lsRememberMe" id="rememberMe"> <label class="remembermetext" for="rememberMe">Remember Me</label>
                <a href="#" class="forgot-password">Forgot Password?</a>
            </div>
                <button type="submit" onclick="lsRememberMe()">Sign In</button>
            </form> 
            <hr class="line">
            <div class="signin">
                <p class="signin">Don't have an account yet?</p>
                <a href="register.php">Create an account</a>
            </div>
        </div>
    </div>
    <script src="script.js"></script> 
</body>
</html>
