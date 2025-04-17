<?php
session_start();
include("includes/db_connection.php");

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
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="container">
        <img src="assets/img/logo.png" alt="Logo" class="logo">
        <div class="title-box">
            <h2>Student Login</h2>
        </div>
        <div class="message-box">
        <?php if (!empty($error_message)): ?>
                    <p class="errormsg"><?php echo htmlspecialchars($error_message); ?></p>
            <?php endif; ?>
        </div>
        <div class="main-box">
            <form action="" method="POST" class="registration-form">
                <input type="text" id="username" placeholder="Username" name="username" class="firstinput" required>
                <input type="password" id="password" placeholder="Password" name="password" required>
                <div class="cookies">
                <input type="checkbox" value="lsRememberMe" id="rememberMe"> <label class="remembermetext" for="rememberMe">Remember Me</label>
                <a href="#" class="forgot-password">Forgot Password?</a>
                </div>
                <button type="submit">Sign In</button>
            </form>
            <hr>
            <p class="noaccount">Don't have an account yet?</p>
            <a class="createaccount" href="register.php">Create an account</a>
        </div>
    </div>
    <script src="assets/script/cookies.js"></script> 
</body>
</html>
