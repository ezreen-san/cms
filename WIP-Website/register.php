<?php
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        $stmt->execute(['username' => $username, 'email' => $email, 'password' => $hashed_password]);
        $success_message = "User Registered Successfully.";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CREATE YOUR ACCOUNT</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="styles2.css">
</head>
<body>
        <header class="logo-section">
            <img src="logo.png" alt="Breyer Logo" class="logo">
        </header>
    <div class="container">

        <main>
            <h1 class="boxlabel">STUDENT REGISTRATION</h1>
            <form action="register.php" method="POST" class="registration-form">
            <?php if (!empty($success_message)): ?>
                    <p class="succmsg"><?php echo htmlspecialchars($success_message); ?></p>
            <?php endif; ?>
                <input type="text" name="username" class="firstinput" placeholder="Username" required>
                <input type="email" name="email" placeholder="Email Address" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                <button type="submit">Register</button>
            </form>
            <hr style="margin-top: 24px;" class="line">
            <div class="signin">
            <p style="margin-bottom: 0px;">Already Registered?</p>
            <a href="signin.php">Sign in</a>
            </div>
        </main>
    </div>
</body>
</html>